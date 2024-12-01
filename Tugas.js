$(document).ready(function () {
    // Efek fade-in untuk semua gambar saat halaman dimuat
    $(".gallery img").each(function (index) {
      $(this).delay(200 * index).fadeTo(500, 1); 
    });

    // Menangani klik pada gambar galeri
    $(".gallery img").click(function () {
      const src = $(this).attr("src"); 
      $(".modal img").attr("src", src); 
      $(".modal").fadeIn();
    });

    // Menutup modal dengan tombol close
    $(".modal .close").click(function () {
      $(".modal").fadeOut(); 
    });

    // Menutup modal dengan klik di luar gambar
    $(".modal").click(function (e) {
      if (!$(e.target).is("img")) { 
        $(".modal").fadeOut();
      }
    });
  });