"use strict";

[].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {
	new SelectFx(el);
} );

jQuery('.selectpicker').selectpicker;


$('#menuToggle').on('click', function(event) {
	$('body').toggleClass('open');
	$('.f-copyright').toggleClass('open-footer');
	$('.header').toggleClass('kkk');
});
$('#menuToggle2').on('click', function(event) {
	$('body').toggleClass('open');
	$('.f-copyright').toggleClass('open-footer');
	$('.header').toggleClass('kkk2');
	$('.left-panel').toggleClass('closenav');
});

$('.search-trigger').on('click', function(event) {
	event.preventDefault();
	event.stopPropagation();
	$('.search-trigger').parent('.header-left').addClass('open');
});

$('.search-close').on('click', function(event) {
	event.preventDefault();
	event.stopPropagation();
	$('.search-trigger').parent('.header-left').removeClass('open');
});

// resize table
$(window).width(function(){
  var win = $(this);
  if (win.width() <= 700) {
    $('#StafTablesTamu').addClass('table-responsive text-nowrap');
    $('#TableTipeKamar').addClass('table-responsive text-nowrap');
	}
	else{
    // $('#StafTablesTamu').removeClass('table-responsive');
    $('#TableTipeKamar').removeClass('table-responsive text-nowrap');
  };
});

// resize
$(window).on('load', function(){
  var win = $(this);
  if (win.width() <= 600) {
    $('.coba').addClass('mb-5');
	}else{
    $('.coba').removeClass('mb-5');
  };
} );


// login show / hide password
$("#btn-toggle-pass").on('click',function() {
	$('#inp-pass').focus();

  var $pwd = $("#inp-pass");
  var $titleold = $('#btn-toggle-pass');

  if ($titleold.attr('title') === 'Show password') {
  	$titleold.attr('title', 'Hide password');
  }else{
  	$titleold.attr('title', 'Show password');
  }
  
  if ($pwd.attr('type') === 'password') {
    $pwd.attr('type', 'text');
  } else {
    $pwd.attr('type', 'password');
  }
});
// register show / hide password --2 / new password
$("#btn-toggle-pass--2").on('click',function() {
	$('#inp-pass--2').focus();

  var $pwd = $("#inp-pass--2");
  var $titleold = $('#btn-toggle-pass--2');

  if ($titleold.attr('title') === 'Show password') {
  	$titleold.attr('title', 'Hide password');
  }else{
  	$titleold.attr('title', 'Show password');
  }
  
  if ($pwd.attr('type') === 'password') {
    $pwd.attr('type', 'text');
  } else {
    $pwd.attr('type', 'password');
  }
});
// register show / hide password --3 / confirm password
$("#btn-toggle-pass--3").on('click',function() {
	$('#inp-pass--3').focus();

  var $pwd = $("#inp-pass--3");
  var $titleold = $('#btn-toggle-pass--3');

  if ($titleold.attr('title') === 'Show password') {
  	$titleold.attr('title', 'Hide password');
  }else{
  	$titleold.attr('title', 'Show password');
  }
  
  if ($pwd.attr('type') === 'password') {
    $pwd.attr('type', 'text');
  } else {
    $pwd.attr('type', 'password');
  }
});

// halaman Ubah password - inp pass lama
$("#btn-toggle-pass-lama").on('click',function() {
	$('#inp-pass-lama').focus();

  var $pwd = $("#inp-pass-lama");
  var $titleold = $('#btn-toggle-pass-lama');

  if ($titleold.attr('title') === 'Show password') {
  	$titleold.attr('title', 'Hide password');
  }else{
  	$titleold.attr('title', 'Show password');
  }
  
  if ($pwd.attr('type') === 'password') {
    $pwd.attr('type', 'text');
  } else {
    $pwd.attr('type', 'password');
  }
});

// halaman Ubah password - inp pass baru
$("#btn-toggle-pass-baru").on('click',function() {
	$('#inp-pass-baru').focus();

  var $pwd = $("#inp-pass-baru");
  var $titleold = $('#btn-toggle-pass-baru');

  if ($titleold.attr('title') === 'Show password') {
  	$titleold.attr('title', 'Hide password');
  }else{
  	$titleold.attr('title', 'Show password');
  }
  
  if ($pwd.attr('type') === 'password') {
    $pwd.attr('type', 'text');
  } else {
    $pwd.attr('type', 'password');
  }
});

// halaman Ubah password - inp pass baru
$("#btn-toggle-pass--3").on('click',function() {
	$('#inp-pass-confirm-tamu').focus();

  var $pwd = $("#inp-pass-confirm-tamu");
  var $titleold = $('#btn-toggle-pass--3');

  if ($titleold.attr('title') === 'Show password') {
  	$titleold.attr('title', 'Hide password');
  }else{
  	$titleold.attr('title', 'Show password');
  }
  
  if ($pwd.attr('type') === 'password') {
    $pwd.attr('type', 'text');
  } else {
    $pwd.attr('type', 'password');
  }
});

// halaman Ubah password pengguna - owner
$("#btn-toggle-ubah-pass").on('click',function() {
	$('#inp-pass-confirm').focus();

  var $pwd = $("#inp-pass-confirm");
  var $titleold = $('#btn-toggle-ubah-pass');

  if ($titleold.attr('title') === 'Show password') {
  	$titleold.attr('title', 'Hide password');
  }else{
  	$titleold.attr('title', 'Show password');
  }
  
  if ($pwd.attr('type') === 'password') {
    $pwd.attr('type', 'text');
  } else {
    $pwd.attr('type', 'password');
  }
});

// confirm password - owner
$('#inp-pass-baru, #inp-pass-confirm').on('keyup', function () {
  if ($('#inp-pass-baru').val() == $('#inp-pass-confirm').val()) {
    $('#pesan svg').css('color', 'green');
    $('#btn-register').prop('disabled', false);
  } else {
    $('#pesan svg').css('color', 'red');
    $('#btn-register').prop('disabled', true);
	}
});

// confirm password - register tamu
$('#inp-pass--2, #inp-pass--3').on('keyup', function () {
  if ($('#inp-pass--2').val() == $('#inp-pass--3').val()) {
    $('#pesan svg').css('color', 'green');
    $('#btn-register').prop('disabled', false);
  } else {
    $('#pesan svg').css('color', 'red');
    $('#btn-register').prop('disabled', true);
	}
});

// confirm password - ubah pwd tamu
$('#inp-pass-baru, #inp-pass-confirm-tamu').on('keyup', function () {
  if ($('#inp-pass-baru').val() == $('#inp-pass-confirm-tamu').val()) {
    $('#pesan svg').css('color', 'green');
    $('#btn-register').prop('disabled', false);
  } else {
    $('#pesan svg').css('color', 'red');
    $('#btn-register').prop('disabled', true);
	}
});

// realtime show images after input
// function readURL(input) {
//   if (input.files && input.files[0]) {
//      var reader = new FileReader();

//      reader.onload = function (e) {
//        $('#blah').attr('src', e.target.result);
//      }

//      reader.readAsDataURL(input.files[0]);
//   }
// }
// $("#imgInp").change(function(){
//   readURL(this);
// });

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      var imgId = '#preview-'+$(input).attr('id');
      $(imgId).attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}
$("input[type='file'].FotoUpload").change(function(){
  readURL(this);
});


// loader
var loader = function() {
	setTimeout(function() { 
		if($('#ftco-loader').length > 0) {
			$('#ftco-loader').removeClass('show');
		}
	}, 1);
};
loader();

