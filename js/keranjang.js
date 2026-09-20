// ===========================================================
// keranjang.js
// Logic bersama untuk fitur "Booking Arsip":
// - Setiap arsip yang ditekan tombol "+ Booking Arsip" akan langsung
//   DIKUNCI (prinsip siapa cepat dia dapat) supaya tidak bisa dibooking
//   pengguna lain, dan otomatis masuk ke "keranjang" milik peminjam.
// - Data disimpan di localStorage supaya konsisten dipakai lintas
//   halaman (index.html, Archive.html, Institution_detail.html,
//   booking_arsip.html / Request.html).
//
// Catatan: penguncian di sini berbasis localStorage (sisi klien),
// jadi ini simulasi "siapa cepat dia dapat" untuk kebutuhan demo.
// Untuk implementasi produksi, penguncian idealnya dilakukan di
// server/database agar benar-benar atomik antar banyak pengguna.
// ===========================================================

const KERANJANG_KEY = "ardarika_keranjang";
const BOOKING_LOCK_KEY = "ardarika_booking_lock";

// Ambil semua arsip yang sedang ada di keranjang peminjam saat ini
function getKeranjang() {
  try {
    return JSON.parse(localStorage.getItem(KERANJANG_KEY)) || [];
  } catch (e) {
    return [];
  }
}

function saveKeranjang(items) {
  localStorage.setItem(KERANJANG_KEY, JSON.stringify(items));
}

// Ambil daftar id arsip yang sudah terkunci (sudah dibooking, oleh siapa pun)
function getBookingLock() {
  try {
    return JSON.parse(localStorage.getItem(BOOKING_LOCK_KEY)) || [];
  } catch (e) {
    return [];
  }
}

function saveBookingLock(ids) {
  localStorage.setItem(BOOKING_LOCK_KEY, JSON.stringify(ids));
}

// Cek apakah arsip dengan id tertentu sudah dikunci (sudah dibooking).
// Dibandingkan sebagai teks (bukan "===" langsung) karena id kadang berupa
// angka (dari database) dan kadang berupa teks (dari onclick="...('${id}')"
// di HTML) — kalau dibandingkan strict, "34" tidak akan pernah sama dengan
// 34 walau sebenarnya arsip yang sama, dan tombol jadi terlihat tidak bereaksi.
function isArsipLocked(id) {
  return getBookingLock().some((lockedId) => String(lockedId) === String(id));
}

// Selaraskan kunci lokal (localStorage) dengan status arsip yang sebenarnya
// dari server. Kunci di localStorage dulunya TIDAK PERNAH otomatis lepas
// setelah booking disubmit (lihat komentar di clearKeranjang()), jadi kalau
// admin sudah menandai "Kembalikan Dokumen" di sisi server (arsip balik jadi
// "tersedia"), browser peminjam yang sama tetap menampilkan "Tidak Tersedia"
// / "Sudah Dibooking" selamanya karena isArsipLocked() cuma baca localStorage
// tanpa pernah dicocokkan ulang ke server. Fungsi ini dipanggil sekali di
// setiap halaman publik (Archive, Home, Institution Detail) begitu data dari
// server (yang sudah punya status "tersedia"/"tidak-tersedia" per arsip)
// selesai dimuat, supaya lock lama yang sudah tidak relevan otomatis lepas.
function syncBookingLockWithServer(items) {
  if (!Array.isArray(items) || items.length === 0) return;

  const tersediaLagiIds = items
    .filter((item) => item && item.status !== "tidak-tersedia")
    .map((item) => String(item.id));

  if (tersediaLagiIds.length === 0) return;

  const locks = getBookingLock();
  const locksBaru = locks.filter(
    (lockedId) => !tersediaLagiIds.includes(String(lockedId)),
  );

  if (locksBaru.length !== locks.length) {
    saveBookingLock(locksBaru);
  }
}

// Tambahkan arsip ke keranjang sekaligus mengunci arsip tsb.
// Mengembalikan true kalau berhasil, false kalau ternyata arsip itu
// baru saja keburu dikunci lebih dulu (siapa cepat dia dapat).
function addToKeranjang(item) {
  const locks = getBookingLock();
  if (locks.some((lockedId) => String(lockedId) === String(item.id))) {
    return false;
  }
  locks.push(item.id);
  saveBookingLock(locks);

  const items = getKeranjang();
  if (!items.some((i) => String(i.id) === String(item.id))) {
    items.push(item);
    saveKeranjang(items);
  }
  refreshFloatingCartUI();
  return true;
}

// Hapus arsip dari keranjang. Kunci booking-nya ikut dilepas supaya
// arsip tsb bisa dibooking lagi oleh pengguna lain.
function removeFromKeranjang(id) {
  saveKeranjang(getKeranjang().filter((i) => String(i.id) !== String(id)));
  saveBookingLock(
    getBookingLock().filter((lockedId) => String(lockedId) !== String(id)),
  );
  refreshFloatingCartUI();
}

// Kosongkan keranjang saja (dipanggil setelah form permintaan arsip
// berhasil dikirim). Kunci booking SENGAJA tidak dihapus di sini,
// karena arsip yang permintaannya sudah diproses tidak boleh
// dibooking ulang oleh orang lain.
function clearKeranjang() {
  saveKeranjang([]);
  refreshFloatingCartUI();
}

// ===========================================================
// FLOATING CART (keranjang mengambang di pojok bawah layar)
// Muncul otomatis di semua halaman yang memuat keranjang.js,
// menampilkan jumlah arsip yang sudah dibooking + daftar
// singkatnya, tanpa perlu pindah halaman dulu.
// ===========================================================

function updateFloatingCartBadge() {
  const badge = document.getElementById("ardarikaCartBadge");
  if (!badge) return;
  const count = getKeranjang().length;
  badge.textContent = count;
  badge.classList.toggle("hidden", count === 0);
}

function renderFloatingCartPanel() {
  const list = document.getElementById("ardarikaCartPanelList");
  if (!list) return;
  const items = getKeranjang();

  if (items.length === 0) {
    list.innerHTML =
      '<p class="text-sm text-slate-500 px-4 py-6 text-center">Belum ada arsip yang dibooking.</p>';
    return;
  }

  list.innerHTML = items
    .map(
      (item) => `
        <div class="flex items-start justify-between gap-3 px-4 py-3 border-b border-slate-100 last:border-b-0">
          <div class="min-w-0">
            <p class="text-sm font-semibold text-slate-800 truncate">${item.instansi} — ${item.uraian}</p>
            <p class="text-xs text-slate-500 mt-0.5">Kode ${item.kode} &middot; Tahun ${item.tahun}</p>
          </div>
          <button
            type="button"
            onclick="handleFloatingCartRemove('${item.id}')"
            class="text-rose-500 hover:text-rose-700 text-xs font-semibold whitespace-nowrap"
          >
            Hapus
          </button>
        </div>`,
    )
    .join("");
}

// Dipanggil dari tombol "Hapus" di dalam panel keranjang mengambang.
// Ikut memanggil ulang fungsi render milik masing-masing halaman
// (kalau ada) supaya tombol "+ Booking Arsip" di daftar arsip juga
// ikut update, tanpa perlu reload halaman.
function handleFloatingCartRemove(id) {
  removeFromKeranjang(id);
  renderFloatingCartPanel();

  if (typeof renderHomeArchives === "function") renderHomeArchives();
  if (
    typeof renderResults === "function" &&
    typeof currentResults !== "undefined"
  )
    renderResults(currentResults);
  if (typeof renderList === "function" && typeof displayedItems !== "undefined")
    renderList(displayedItems);
  if (typeof renderKeranjang === "function") renderKeranjang();
}

function toggleFloatingCartPanel(forceOpen) {
  const panel = document.getElementById("ardarikaCartPanel");
  if (!panel) return;

  const shouldOpen =
    typeof forceOpen === "boolean"
      ? forceOpen
      : panel.classList.contains("hidden");

  panel.classList.toggle("hidden", !shouldOpen);
  if (shouldOpen) renderFloatingCartPanel();
}

// Dipanggil setiap kali isi keranjang berubah (tambah/hapus/kosongkan)
// supaya badge angka & panel selalu sinkron dengan localStorage terbaru.
function refreshFloatingCartUI() {
  updateFloatingCartBadge();
  const panel = document.getElementById("ardarikaCartPanel");
  if (panel && !panel.classList.contains("hidden")) {
    renderFloatingCartPanel();
  }
}

function injectFloatingCart() {
  if (document.getElementById("ardarikaFloatingCart")) return;

  const isHalamanPermintaan = /\/booking/i.test(
    window.location.pathname,
  );

  const wrapper = document.createElement("div");
  wrapper.id = "ardarikaFloatingCart";
  wrapper.style.position = "fixed";
  wrapper.style.bottom = "24px";
  wrapper.style.right = "24px";
  wrapper.style.zIndex = "70";
  wrapper.innerHTML = `
    <div id="ardarikaCartPanel" class="hidden mb-3 w-80 max-w-[85vw] bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden">
      <div class="px-4 py-3 bg-[#112240] text-white flex items-center justify-between">
        <span class="font-semibold text-sm">Keranjang Booking</span>
        <button type="button" onclick="toggleFloatingCartPanel(false)" class="text-white/70 hover:text-white text-lg leading-none">&times;</button>
      </div>
      <div id="ardarikaCartPanelList" class="max-h-72 overflow-y-auto"></div>
      <div class="p-3 border-t border-slate-100">
        ${
          isHalamanPermintaan
            ? `<button type="button" onclick="toggleFloatingCartPanel(false); document.getElementById('keranjangList')?.scrollIntoView({behavior:'smooth', block:'center'});" class="block w-full text-center bg-[#2563EB] text-white text-sm font-semibold rounded-xl px-4 py-2.5 hover:bg-blue-700 transition">Lihat di Formulir</button>`
            : `<a href="/booking" class="block text-center bg-[#2563EB] text-white text-sm font-semibold rounded-xl px-4 py-2.5 hover:bg-blue-700 transition">Lanjutkan ke Permintaan Arsip</a>`
        }
      </div>
    </div>
    <button
      type="button"
      onclick="toggleFloatingCartPanel()"
      class="relative w-16 h-16 rounded-full text-white shadow-xl flex items-center justify-center hover:opacity-90 transition"
      style="background-color:#2563EB"
      aria-label="Keranjang Booking Arsip"
    >
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-7 h-7">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.803-4.735 2.032-7.235.055-.617-.421-1.15-1.041-1.15H5.25M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
      </svg>
      <span id="ardarikaCartBadge" class="hidden absolute -top-1.5 -right-1.5 bg-rose-500 text-white text-xs font-bold w-6 h-6 rounded-full flex items-center justify-center border-2 border-white">0</span>
    </button>
  `;

  document.body.appendChild(wrapper);
  updateFloatingCartBadge();
}

document.addEventListener("DOMContentLoaded", injectFloatingCart);

// Sinkron kalau keranjang diubah dari tab/halaman lain
window.addEventListener("storage", (e) => {
  if (e.key === KERANJANG_KEY || e.key === BOOKING_LOCK_KEY) {
    refreshFloatingCartUI();
  }
});
