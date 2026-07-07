<?php
    header("Content-Type:text/css");
    if ( isset( $_GET[ 'color1' ] ) && $_GET[ 'color1' ] != '' ) {
        $color1 = "#".$_GET['color1'];
    }
    if ( isset( $_GET[ 'color2' ] ) && $_GET[ 'color2' ] != '' ) {
        $color2 = "#".$_GET['color2'];
    }

    function checkhexcolor1($color1) {
      return preg_match('/^#[a-f0-9]{6}$/i', $color1);
    }

    function checkhexcolor2($color2) {
      return preg_match('/^#[a-f0-9]{6}$/i', $color2);
    }

    if( !$color1 || !checkhexcolor1( $color1 ) ) {
      $color1 = "#ea0117";
    }

    if( !$color2 || !checkhexcolor2( $color2 ) ) {
      $color2 = "#ea0117";
    }
?>

.ptc-card {
    border: 1px solid <?php echo $color1 ?>80;
    background: linear-gradient(to bottom, <?php echo $color1 ?>40, #fff) !important;
}


.price .single-price .part-bottom button:hover {
    background: transparent;
    color: <?php echo $color1 ?>;
}

.header .main-menu li a:hover, .header .main-menu li a:focus {
    color: <?php echo $color1 ?>;
}

.btn--base,.cmn-btn {
    background-color: <?php echo $color1 ?>;
}

.btn--base:hover, .cmn-btn:hover {
    color: #ffffff;
    background-color: <?php echo $color2 ?>;
}

.btn--base:active, .cmn-btn:active {
    color: #ffffff;
    background-color: <?php echo $color1 ?> !important;
}

.btn--base:focus, .cmn-btn:focus {
    color: #ffffff;
    background-color: <?php echo $color1 ?> !important;
}

.text--base{
    color: <?php echo $color1 ?>;
}

.style--three:hover{
    background-color: <?php echo $color1 ?>;
}

.hero__slider .slick-arrow::before {
    background-color: <?php echo $color1 ?>;
}

.video-thumb .video-icon {
    position: absolute;
    background-color: <?php echo $color1 ?>;
}
.scroll-to-top {
    background-color: <?php echo $color1 ?>;
}

.feature-card__icon {
    color: <?php echo $color1 ?>;
}

.price .single-price .part-bottom button {
    background: <?php echo $color1 ?>;
    border: 2px solid <?php echo $color1 ?>;
}
.header.menu-fixed .header__bottom {
    background-color: <?php echo $color2 ?>;
}
.bg--base {
    background-color: <?php echo $color1 ?>;
}
.slick-dots li.slick-active button {
    background-color: <?php echo $color1 ?>;
}
.blog-details__footer .social__links li a:hover {
    background-color: <?php echo $color1 ?>;
}
.blog-details__thumb .post__date .date {
    background-color: <?php echo $color1 ?>;
}

.sidebar .widget .widget__title::after {
    background-color: <?php echo $color1 ?>;
}

.btn-success:not(:disabled):not(.disabled).active, .btn-success:not(:disabled):not(.disabled):active, .show>.btn-success.dropdown-toggle {
    background-color: <?php echo $color1 ?>;
    border-color: <?php echo $color1 ?>;
}

a {
    color: <?php echo $color1 ?>;
    text-decoration: none;
    background-color: transparent;
}

.d-pagination .pagination li.active a {
    background-color: <?php echo $color1 ?>;
    color: #ffffff;
}
.page-item.active .page-link {
    background-color: <?php echo $color1 ?>;
    border-color: <?php echo $color1 ?>;
}

.d-pagination .pagination li a:hover {
    color: <?php echo $color1 ?>;
    border-color: <?php echo $color1 ?>;
}
.preloader {
    background-color: <?php echo $color1 ?>;
}

.header .main-menu li .sub-menu {
    background-color: <?php echo $color1 ?>;
    border-top: 2px solid <?php echo $color1 ?>;
}

.form-control:focus, .form--select:focus {
    border-color: <?php echo $color1 ?>4a;
}

.footer-section {
    background-color: <?php echo $color2 ?>;
}

.bg--primary {
    background-color: <?php echo $color1 ?>!important;
}
.bg--success {
    background-color: <?php echo $color1 ?>!important;
}

.bb--3 {
    border-color: <?php echo $color1 ?>!important;
}
.table .thead-dark th {
    background-color: <?php echo $color1 ?>;
    border:none;
}
.bg-primary {
    background-color: <?php echo $color1 ?>!important;
    color:#fff;
}
.b-primary{
    border: 1px solid <?php echo $color1 ?>7a !important;
}

.pricing--popular{
    border: 2px solid <?php echo $color1 ?>
}



.btn--primary {
    background-color:<?php echo $color1 ?>!important;

}


.btn--primary:hover, .btn--primary:focus, .btn--primary:focus-visible {
    background-color:<?php echo $color2 ?>!important;

}

.select2-container--default .select2-search--dropdown .select2-search__field:focus {
  border-color:1px solid <?php echo $color1 ?>!important;

}

.select2-container--open .select2-selection.select2-selection--single, .select2-container--open .select2-selection.select2-selection--multiple {
    border-color:1px solid <?php echo $color1 ?>!important;

}

.payment-card-title {
 
  background-color: <?php echo $color1 ?>!important;

}


.payment-system-list {

  --hover-border-color: <?php echo $color1 ?>!important;


}


.payment-system-list.is-scrollable::-webkit-scrollbar-thumb {
  background-color:<?php echo $color1 ?>!important;

}

.payment-item:has(.payment-item__radio:checked) .payment-item__check {
  border: 3px solid <?php echo $color1 ?>!important;
}

.payment-item__check {

  border: 1px solid <?php echo $color1 ?>!important;


}



.btn.disabled, .btn:disabled, fieldset:disabled .btn {
  
  background-color:<?php echo $color1 ?>!important;

}

.daterangepicker td.active, .daterangepicker td.active:hover, .daterangepicker .ranges li.active {
    background-color: <?php echo $color1 ?>!important;
}

.form-disabled-text svg path{
            fill:<?php echo $color1 ?>!important;
         }