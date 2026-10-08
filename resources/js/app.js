document.addEventListener("DOMContentLoaded", function () {
  // TAMBAH MENU KE KERANJANG

  const addForms = document.querySelectorAll(".add-form");

  addForms.forEach(function (form) {
    form.addEventListener("submit", async function (event) {
      event.preventDefault();

      const button = form.querySelector(".btn-add");

      if (button) {
        button.disabled = true;
      }

      try {
        const formData = new FormData(form);

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
          throw new Error(data.message || "Gagal menambahkan menu.");
        }

        // Reload bagian keranjang saja
        updateCartDisplay(data);
      } catch (error) {
        alert(error.message);
      } finally {
        if (button) {
          button.disabled = false;
        }
      }
    });
  });

  // HAPUS MENU DARI KERANJANG

  const removeForms = document.querySelectorAll(".cart-remove-form");

  removeForms.forEach(function (form) {
    form.addEventListener("submit", async function (event) {
      event.preventDefault();

      const button = form.querySelector("button");

      if (button) {
        button.disabled = true;
      }

      try {
        const formData = new FormData(form);

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
          throw new Error(data.message || "Gagal menghapus menu.");
        }

        // Hapus item dari tampilan
        const cartItem = form.closest(".cart-item");

        if (cartItem) {
          cartItem.remove();
        }

        // Update total
        updateCartTotal(data.total);

        // Jika keranjang sudah kosong
        if (Object.keys(data.cart).length === 0) {
          showEmptyCart();
        }
      } catch (error) {
        alert(error.message);

        if (button) {
          button.disabled = false;
        }
      }
    });
  });

  // UPDATE TAMPILAN KERANJANG

  function updateCartDisplay(data) {
    /*
     * Untuk sementara kita reload halaman jika
     * struktur keranjang belum memiliki elemen dinamis.
     *
     * Nanti bagian ini bisa dibuat benar-benar
     * tanpa reload jika tombol + / - juga dibuat AJAX.
     */
    window.location.reload();
  }

  // UPDATE TOTAL

  function updateCartTotal(total) {
    const cartTotal = document.querySelector(".cart-total");

    if (!cartTotal) {
      return;
    }

    cartTotal.innerHTML =
      "Total: Rp " + new Intl.NumberFormat("id-ID").format(total);
  }

  //  KERANJANG KOSONG

  function showEmptyCart() {
    const cart = document.querySelector(".cart");

    if (!cart) {
      return;
    }

    cart.innerHTML = `
            <h2>Keranjang</h2>
            <p>Keranjang masih kosong.</p>
        `;
  }
});
