document.addEventListener("DOMContentLoaded", function () {
  //TAMBAH MENU
  document.querySelectorAll(".add-form").forEach(function (form) {
    form.addEventListener("submit", async function (event) {
      event.preventDefault();

      const button = form.querySelector(".btn-add");

      if (button) {
        button.disabled = true;
      }

      try {
        const response = await fetch(form.action, {
          method: "POST",
          headers: {
            "X-Requested-With": "XMLHttpRequest",
            Accept: "application/json",
          },
          body: new FormData(form),
        });

        const data = await response.json();

        if (!response.ok || !data.success) {
          throw new Error(data.message || "Gagal menambahkan menu.");
        }

        renderCart(data.cart, data.total);
      } catch (error) {
        alert(error.message);
      } finally {
        if (button) {
          button.disabled = false;
        }
      }
    });
  });

  // EVENT KERANJANG
  function bindCartEvents() {
    // HAPUS
    document.querySelectorAll(".cart-remove-form").forEach(function (form) {
      form.addEventListener("submit", async function (event) {
        event.preventDefault();

        const button = form.querySelector("button");

        if (button) {
          button.disabled = true;
        }

        try {
          const response = await fetch(form.action, {
            method: "POST",
            headers: {
              "X-Requested-With": "XMLHttpRequest",
              Accept: "application/json",
            },
            body: new FormData(form),
          });

          const data = await response.json();

          if (!response.ok || !data.success) {
            throw new Error(data.message || "Gagal menghapus menu.");
          }

          renderCart(data.cart, data.total);
        } catch (error) {
          alert(error.message);

          if (button) {
            button.disabled = false;
          }
        }
      });
    });

    // + DAN -
    document.querySelectorAll(".cart-update-form").forEach(function (form) {
      form.addEventListener("submit", async function (event) {
        event.preventDefault();

        // Ambil tombol yang benar-benar ditekan
        const button = event.submitter;

        if (!button || button.name !== "quantity") {
          return;
        }

        // Ambil nilai quantity dari tombol sebagai angka
        const quantity = Number(button.value);

        if (!Number.isInteger(quantity) || quantity < 1) {
          return;
        }

        button.disabled = true;

        try {
          const formData = new FormData(form);

          // Pastikan quantity dikirim sebagai nilai tombol,
          // bukan digabungkan dengan nilai sebelumnya.
          formData.delete("quantity");
          formData.append("quantity", String(quantity));

          const response = await fetch(form.action, {
            method: "POST",
            headers: {
              "X-Requested-With": "XMLHttpRequest",
              Accept: "application/json",
            },
            body: formData,
          });

          const data = await response.json();

          if (!response.ok || !data.success) {
            throw new Error(data.message || "Gagal memperbarui jumlah.");
          }

          renderCart(data.cart, data.total);
        } catch (error) {
          alert(error.message);
          button.disabled = false;
        }
      });
    });
  }

  // RENDER KERANJANG
  function renderCart(cart, total) {
    const cartElement = document.querySelector(".cart");

    if (!cartElement) {
      return;
    }

    const items = Object.values(cart);

    // Keranjang kosong
    if (items.length === 0) {
      cartElement.innerHTML = `
      <h2>Keranjang</h2>
      <p>Keranjang masih kosong.</p>
    `;

      return;
    }

    // Daftar item keranjang
    let itemsHtml = "";

    items.forEach(function (item) {
      const price = formatRupiah(item.price);
      const subtotal = formatRupiah(item.subtotal);

      itemsHtml += `
      <div class="cart-item">

        <div class="cart-name">
          ${escapeHtml(item.name)}
        </div>

        <div class="cart-detail">
          Rp ${price} × ${item.quantity}
        </div>

        <div class="cart-subtotal">
          Rp ${subtotal}
        </div>

        <form
          action="/transactions/cart/update"
          method="POST"
          class="cart-update-form"
        >
          <input
            type="hidden"
            name="_token"
            value="${getCsrfToken()}"
          >

          <input
            type="hidden"
            name="menu_id"
            value="${item.menu_id}"
          >

          <button
            type="submit"
            name="quantity"
            value="${Number(item.quantity) - 1}"
            class="btn"
            ${item.quantity <= 1 ? "disabled" : ""}
          >
            −
          </button>

          <span class="cart-quantity">
            ${item.quantity}
          </span>

          <button
            type="submit"
            name="quantity"
            value="${Number(item.quantity) + 1}"
            class="btn"
          >
            +
          </button>
        </form>

        <form
          action="/transactions/cart/remove"
          method="POST"
          class="cart-remove-form"
        >
          <input
            type="hidden"
            name="_token"
            value="${getCsrfToken()}"
          >

          <input
            type="hidden"
            name="menu_id"
            value="${item.menu_id}"
          >

          <button type="submit" class="btn">
            Hapus
          </button>
        </form>

      </div>
    `;
    });

    // Render keranjang dengan daftar item terpisah
    let html = `
    <h2>Keranjang</h2>

    <div class="cart-items">
      ${itemsHtml}
    </div>

    <div class="cart-total">
      Total:
      Rp ${formatRupiah(total)}
    </div>

    <div class="payment-section">
      <h3>Pembayaran</h3>

      <form
        action="/transactions/payment"
        method="POST"
      >
        <input
          type="hidden"
          name="_token"
          value="${getCsrfToken()}"
        >

        <label for="payment_amount">
          Jumlah Pembayaran
        </label>

        <input
          type="number"
          name="payment_amount"
          id="payment_amount"
          min="${total}"
          step="1000"
          placeholder="Masukkan jumlah uang"
          class="payment-input"
          required
        >

        <button
          type="submit"
          class="payment-button"
        >
          BAYAR
        </button>
      </form>
    </div>
  `;

    cartElement.innerHTML = html;

    // Aktifkan kembali event setelah HTML diganti
    bindCartEvents();
  }

  // FORMAT RUPIAH
  function formatRupiah(number) {
    return new Intl.NumberFormat("id-ID").format(number);
  }

  // CSRF TOKEN
  function getCsrfToken() {
    const token = document.querySelector('meta[name="csrf-token"]');

    return token ? token.getAttribute("content") : "";
  }

  // ESCAPE HTML
  function escapeHtml(value) {
    const div = document.createElement("div");

    div.textContent = value;

    return div.innerHTML;
  }

  // AKTIFKAN EVENT AWAL
  bindCartEvents();
});
