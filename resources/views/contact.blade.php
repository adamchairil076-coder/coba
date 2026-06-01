<!DOCTYPE html>
<html lang="zxx">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/icofont.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/meanmenu.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/modal-video.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/fonts/flaticon.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/lightbox.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/odometer.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/nice-select.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/theme-dark.css') }}">

   <title>Kontak</title>
   <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">
</head>

<body>
   <div class="loader">
      <div class="d-table">
         <div class="d-table-cell">
            <div class="pre-box-one">
               <div class="pre-box-two"></div>
            </div>
         </div>
      </div>
   </div>

   <div class="navbar-area sticky-top">
      <div class="mobile-nav">
         <a href="{{ route('index') }}" class="logo">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" width="40">
         </a>
      </div>

      <div class="main-nav">
         <div class="container">
            @include('components.home.navbar', ['categories' => App\Models\Category::all()])
         </div>
      </div>
   </div>

   <div class="contact-info-area pt-100 pb-70">
      <div class="container mt-4">
         <div class="row">
            <div class="col-sm-6 col-lg-4">
               <div class="contact-info">
                  <i class="icofont-location-pin"></i>
                  <span>Lokasi:</span>
                  <a href="#">Jl. Betet 1 Jl. Kp. Kb. Kopi No.Road, Pengasinan, Kec. Gn. Sindur, Kabupaten Bogor, Jawa Barat 16340</a>
               </div>
            </div>

            <div class="col-sm-6 col-lg-4">
               <div class="contact-info">
                  <i class="icofont-ui-call"></i>
                  <span>Telepon:</span>
                  <a href="tel:08119428788">0811 9428 788</a>
               </div>
            </div>

            <div class="col-sm-6 offset-sm-3 offset-lg-0 col-lg-4">
               <div class="contact-info">
                  <i class="icofont-ui-email"></i>
                  <span>Email:</span>
                  <a href="mailto:ruhama@gmail.com">ruhama@gmail.com</a>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="contact-area pb-70">
      <div class="container">

         @guest
            <div class="alert alert-warning mb-4">
               <strong>Perhatian!</strong> Silakan login terlebih dahulu untuk mengirim pesan.
               <a href="{{ route('login') }}" style="color: #ff6015; font-weight: 700;">
                  Login di sini
               </a>
            </div>
         @endguest

         <form id="contactForm">
            <h2>Kirim pesan</h2>
            @csrf

            <div class="row">
               <div class="col-lg-6">
                  <div class="form-group">
                     <label>
                        <i class="icofont-user-alt-3"></i>
                     </label>
                     <input type="text"
                            name="name"
                            class="form-control"
                            placeholder="Nama"
                            value="{{ auth()->check() ? auth()->user()->name : '' }}"
                            required
                            data-error="Mohon masukkan nama">
                     <div class="help-block with-errors"></div>
                  </div>
               </div>

               <div class="col-lg-6">
                  <div class="form-group">
                     <label>
                        <i class="icofont-ui-email"></i>
                     </label>
                     <input type="email"
                            name="email"
                            class="form-control"
                            placeholder="Email"
                            value="{{ auth()->check() ? auth()->user()->email : '' }}"
                            required
                            data-error="Mohon masukkan email">
                     <div class="help-block with-errors"></div>
                  </div>
               </div>

               <div class="col-lg-6">
                  <div class="form-group">
                     <label>
                        <i class="icofont-ui-call"></i>
                     </label>
                     <input type="text"
                            name="phone"
                            placeholder="No. HP"
                            maxlength="13"
                            pattern="[0-9]{1,13}"
                            required
                            data-error="Nomor HP maksimal 13 digit dan hanya boleh angka"
                            class="form-control">
                     <div class="help-block with-errors"></div>
                  </div>
               </div>

               <div class="col-lg-6">
                  <div class="form-group">
                     <label>
                        <i class="icofont-notepad"></i>
                     </label>
                     <input type="text"
                            name="subject"
                            class="form-control"
                            placeholder="Subjek"
                            required
                            data-error="Mohon masukkan subjek pesan">
                     <div class="help-block with-errors"></div>
                  </div>
               </div>

               <div class="col-lg-12">
                  <div class="form-group">
                     <label>
                        <i class="icofont-comment"></i>
                     </label>
                     <textarea name="message"
                               class="form-control"
                               cols="30"
                               rows="8"
                               placeholder="Tulis pesan"
                               required
                               data-error="Mohon masukkan pesan yang akan dikirim"></textarea>
                     <div class="help-block with-errors"></div>
                  </div>
               </div>

               <div class="col-lg-12">
                  <button type="submit" class="btn common-btn">
                     Kirim
                  </button>

                  <div id="msgSubmit" class="h3 text-center hidden mt-3"></div>
                  <div class="clearfix"></div>
               </div>
            </div>
         </form>
      </div>
   </div>

   <div class="map-area">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.159463827926!2d106.68517467499167!3d-6.37340429361682!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69e5cf860bf8cb%3A0x89f1c6cdf7e71af1!2sRumah%20Yatim%20%26%20Pesantren%20Ruhama!5e0!3m2!1sen!2sid!4v1779981609352!5m2!1sen!2sid"
              width="600"
              height="450"
              style="border:0;"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              id="map"></iframe>
   </div>

   <footer class="footer-area pt-100 pb-70" style="background: #111111; color: #ffffff;">
      <div class="container">
         <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
               <div class="footer-item">
                  <div class="footer-logo mb-3">
                     <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="width: 70px;">
                  </div>

                  <h3 style="color: #ffffff;">
                     Rumah Yatim & Pesantren Ruhama
                  </h3>

                  <p style="color: #cfcfcf; line-height: 1.9;">
                     Rumah Yatim & Pesantren Ruhama merupakan platform donasi online
                     yang membantu masyarakat menyalurkan bantuan kepada anak yatim,
                     pendidikan pesantren, dan masyarakat yang membutuhkan secara aman,
                     cepat, dan transparan.
                  </p>
               </div>
            </div>

            <div class="col-lg-2 col-md-6 mb-4">
               <div class="footer-item">
                  <h3 style="color: #ffffff;">Menu</h3>

                  <ul style="list-style: none; padding: 0; line-height: 2.2;">
                     <li>
                        <a href="{{ route('index') }}" style="color: #cfcfcf;">Home</a>
                     </li>
                     <li>
                        <a href="{{ route('index') }}#donasi" style="color: #cfcfcf;">Donasi</a>
                     </li>
                     <li>
                        <a href="{{ route('contact') }}" style="color: #cfcfcf;">Kontak</a>
                     </li>
                  </ul>
               </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
               <div class="footer-item">
                  <h3 style="color: #ffffff;">Kontak</h3>

                  <ul style="list-style: none; padding: 0; line-height: 2.2;">
                     <li style="color: #cfcfcf;">
                        <i class="icofont-ui-email"></i>
                        ruhama@gmail.com
                     </li>

                     <li style="color: #cfcfcf;">
                        <i class="icofont-phone"></i>
                        0811 9428 788
                     </li>

                     <li style="color: #cfcfcf;">
                        <i class="icofont-location-pin"></i>
                        Kabupaten Bogor, Jawa Barat
                     </li>
                  </ul>
               </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
               <div class="footer-item">
                  <h3 style="color: #ffffff;">Social Media</h3>

                  <p style="color: #cfcfcf;">
                     Ikuti informasi dan kegiatan terbaru RUHAMA melalui media sosial kami.
                  </p>

                  <div class="mt-3">
                     <a href="https://www.instagram.com/rumahyatimruhama" target="_blank" style="display:inline-flex;align-items:center;justify-content:center;width:42px;height:42px;background:#ff6015;color:white;border-radius:50%;margin-right:10px;font-size:18px;">
                        <i class="icofont-instagram"></i>
                     </a>

                     <a href="https://share.google/gPax7TduevtO4QhFW" target="_blank" style="display:inline-flex;align-items:center;justify-content:center;width:42px;height:42px;background:#ff6015;color:white;border-radius:50%;margin-right:10px;font-size:18px;">
                        <i class="icofont-facebook"></i>
                     </a>

                     <a href="https://www.youtube.com/@RuhamaTV" target="_blank" style="display:inline-flex;align-items:center;justify-content:center;width:42px;height:42px;background:#ff6015;color:white;border-radius:50%;font-size:18px;">
                        <i class="icofont-youtube-play"></i>
                     </a>
                  </div>
               </div>
            </div>
         </div>

         <hr style="border-color: rgba(255,255,255,0.1);">

         <div class="text-center pt-3">
            <p style="color: #cfcfcf; margin-bottom: 0;">
               Copyright ©
               <script>document.write(new Date().getFullYear())</script>
               <span style="color: #ff6015;">Rumah Yatim & Pesantren Ruhama</span>
               | All Rights Reserved
            </p>
         </div>
      </div>
   </footer>

   <div class="go-top">
      <i class="icofont-arrow-up"></i>
      <i class="icofont-arrow-up"></i>
   </div>

   <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
   <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
   <script src="{{ asset('assets/js/form-validator.min.js') }}"></script>
   <script src="{{ asset('assets/js/jquery.ajaxchimp.min.js') }}"></script>
   <script src="{{ asset('assets/js/jquery.meanmenu.js') }}"></script>
   <script src="{{ asset('assets/js/jquery-modal-video.min.js') }}"></script>
   <script src="{{ asset('assets/js/wow.min.js') }}"></script>
   <script src="{{ asset('assets/js/lightbox.min.js') }}"></script>
   <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
   <script src="{{ asset('assets/js/odometer.min.js') }}"></script>
   <script src="{{ asset('assets/js/jquery.appear.min.js') }}"></script>
   <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
   <script src="{{ asset('assets/js/custom.js') }}"></script>

   <script>
      (function ($) {
         "use strict";

         $("#contactForm").validator().on("submit", function (event) {
            if (event.isDefaultPrevented()) {
               formError();
               submitMSG(false, "Mohon isi form dengan benar.");
            } else {
               event.preventDefault();

               @guest
                  alert('Silakan login terlebih dahulu untuk mengirim pesan.');
                  window.location.href = "{{ route('login') }}";
                  return false;
               @endguest

               submitForm();
            }
         });

         function submitForm() {
            const name = $("[name='name']").val();
            const email = $("[name='email']").val();
            const msg_subject = $("[name='subject']").val();
            const phone_number = $("[name='phone']").val();
            const message = $("[name='message']").val();
            const token = '{{ csrf_token() }}';

            if (phone_number.length > 13) {
               submitMSG(false, "Nomor HP maksimal 13 digit.");
               return false;
            }

            if (!/^[0-9]+$/.test(phone_number)) {
               submitMSG(false, "Nomor HP hanya boleh berisi angka.");
               return false;
            }

            $('[type="submit"]').text('Mengirim...');
            $('[type="submit"]').attr('disabled', true);

            $.ajax({
               type: "POST",
               url: "{{ route('contact.store') }}",
               data: {
                  name: name,
                  email: email,
                  subject: msg_subject,
                  phone: phone_number,
                  message: message,
                  _token: token
               },
               success: function(text) {
                  if (text == "success") {
                     formSuccess();
                  } else {
                     formError();
                     submitMSG(false, text);
                  }
               },
               error: function(xhr) {
                  $('[type="submit"]').text('Kirim');
                  $('[type="submit"]').removeAttr('disabled');

                  if (xhr.status === 401 || xhr.status === 403) {
                     alert('Silakan login terlebih dahulu untuk mengirim pesan.');
                     window.location.href = "{{ route('login') }}";
                     return false;
                  }

                  if (xhr.status === 422) {
                     submitMSG(false, "Data yang dimasukkan belum valid. Pastikan nomor HP maksimal 13 digit dan hanya angka.");
                     return false;
                  }

                  submitMSG(false, "Gagal mengirim pesan. Silakan coba lagi.");
               }
            });
         }

         function formSuccess() {
            $('[type="submit"]').text('Kirim');
            $('[type="submit"]').removeAttr('disabled');
            $("#contactForm")[0].reset();
            submitMSG(true, "Pesan telah dikirim!");
         }

         function formError() {
            $("#contactForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
               $(this).removeClass();
            });
         }

         function submitMSG(valid, msg) {
            const msgClasses = valid ? "h4 tada animated text-success" : "h4 text-danger";
            $("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
         }

      }(jQuery));
   </script>
</body>
</html>