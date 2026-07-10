
<!DOCTYPE html>
<html lang="en">

<head>
	
	<title>Adsnoval - Earn Daily by Clicking Ads – Join Our PPC Platform Today!</title>

	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="StackBros">
	<meta name="description" content="Join our pay-per-click platform and earn daily by clicking ads, referring users, and unlocking new income opportunities. Fast, secure, and easy to use. Start earning now!">
	
	
<!-- PWA Manifest -->
<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#ff6600">

<!-- Service Worker Registration -->
<script>
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/service-worker.js').then(function(registration) {
      console.log('Service Worker Registered with scope:', registration.scope);
    }).catch(function(error) {
      console.log('Service Worker Registration failed:', error);
    });
  }
</script>

	<!-- Dark mode -->
	<script>
		const storedTheme = localStorage.getItem('theme')
 
		const getPreferredTheme = () => {
			if (storedTheme) {
				return storedTheme
			}
			return 'dark'
		}

		const setTheme = function (theme) {
			if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
				document.documentElement.setAttribute('data-bs-theme', 'dark')
			} else {
				document.documentElement.setAttribute('data-bs-theme', theme)
			}
		}

		setTheme(getPreferredTheme())

		window.addEventListener('DOMContentLoaded', () => {
		    var el = document.querySelector('.theme-icon-active');
			if(el != 'undefined' && el != null) {
				const showActiveTheme = theme => {
				const activeThemeIcon = document.querySelector('.theme-icon-active use')
				const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
				const svgOfActiveBtn = btnToActive.querySelector('.mode-switch use').getAttribute('href')

				document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
					element.classList.remove('active')
				})

				btnToActive.classList.add('active')
				activeThemeIcon.setAttribute('href', svgOfActiveBtn)
			}

			window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
				if (storedTheme !== 'light' || storedTheme !== 'dark') {
					setTheme(getPreferredTheme())
				}
			})

			showActiveTheme(getPreferredTheme())

			document.querySelectorAll('[data-bs-theme-value]')
				.forEach(toggle => {
					toggle.addEventListener('click', () => {
						const theme = toggle.getAttribute('data-bs-theme-value')
						localStorage.setItem('theme', theme)
						setTheme(theme)
						showActiveTheme(theme)
					})
				})

			}
		})
		
	</script>

	<!-- Favicon -->
	<link rel="shortcut icon" href="core/resources/views/templates/ptc_diamond/home/assets/images/favicon.png">

	<!-- Google Font -->
	<link rel="preconnect" href="https://fonts.googleapis.com/">
	<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet">

	<!-- Plugins CSS -->
	<link rel="stylesheet" type="text/css" href="core/resources/views/templates/ptc_diamond/home/assets/vendor/bootstrap-icons/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="core/resources/views/templates/ptc_diamond/home/assets/vendor/swiper/swiper-bundle.min.css">
	<link rel="stylesheet" type="text/css" href="core/resources/views/templates/ptc_diamond/home/assets/vendor/aos/aos.css">
  
	<!-- Theme CSS -->
	<link rel="stylesheet" type="text/css" href="core/resources/views/templates/ptc_diamond/home/assets/css/style.css">

	<!-- AdsNoval dark-neon accents -->
	<style>
		:root { --nv-accent: #ff9142; --nv-primary: #7c3aed; --nv-grad: linear-gradient(135deg, #7c3aed 0%, #9333ea 45%, #f97316 100%); }
		[data-bs-theme=dark] { --bs-body-bg: #0a0e1a; --bs-primary: #7c3aed; --bs-primary-rgb: 124,58,237; --bs-link-color: #ff9142; --bs-link-hover-color: #ffbb80; }
		[data-bs-theme=dark] body {
			background:
				radial-gradient(1000px 500px at 85% -5%, rgba(124,58,237,.16), transparent 60%),
				radial-gradient(800px 450px at -8% 8%, rgba(249,115,22,.12), transparent 55%),
				#0a0e1a;
		}
		.btn-primary, .btn.btn-primary { background: var(--nv-grad) !important; border: none !important; box-shadow: 0 14px 30px -14px rgba(124,58,237,.85); }
		.btn-primary:hover { filter: brightness(1.08); }
		.btn-dark { background: rgba(255,255,255,.08) !important; border: 1px solid rgba(255,255,255,.14) !important; color: #fff !important; }
		.text-primary { color: var(--nv-accent) !important; }
		.bg-primary { background: var(--nv-grad) !important; }
		.login-btn { background: var(--nv-grad) !important; color: #fff !important; border: none !important; box-shadow: 0 12px 26px -14px rgba(124,58,237,.9); }
		.header-sticky.bg-transparent { background: rgba(10,14,26,.6) !important; backdrop-filter: blur(10px); }
	</style>

</head>

<body>

<!-- Header START -->
<div class="header-absolute">
	<!-- Header START -->
	<header class="header-sticky bg-transparent">
		<!-- Logo Nav START -->
		<nav class="navbar navbar-expand-xl">
			<div class="container">
				<!-- Logo START -->
				<a class="navbar-brand me-0" href="#">
					<img class="light-mode-item navbar-brand-item" src="core/resources/views/templates/ptc_diamond/home/assets/images/logo.png" alt="logo">
					<img class="dark-mode-item navbar-brand-item" src="core/resources/views/templates/ptc_diamond/home/assets/images/logo.png" alt="logo">
				</a>
				<!-- Logo END -->

				<!-- Main navbar START -->
			

					<!-- Nav item -->
					<div class="navbar-collapse collapse" id="navbarCollapse">
                
                    <ul class="navbar-nav navbar-nav-scroll dropdown-hover mx-auto">
                         <li>
                        @guest
                            <a href="{{ route('user.login') }}" class="login-btn rounded-pill">
                                <span class="login-btn__icon">
                                    <i class="las la-user"></i>
                                </span>
                                <span class="login-btn__text">@lang('Login/Signup')</span>
                            </a>
                        @else
                            <a href="{{ route('user.home') }}" class="login-btn rounded-pill">
                                <span class="login-btn__icon">
                                    <i class="las la-tachometer-alt"></i>
                                </span>
                                <span class="login-btn__text">@lang('Dashboard')</span>
                            </a>
                        @endguest
                    </li>
					
				</ul>
				
			</div>
				<!-- Main navbar END -->

				<!-- Buttons -->
				<ul class="nav align-items-center dropdown-hover ms-sm-2">
					<!-- Dark mode option START -->
					<li class="nav-item dropdown dropdown-animation">
						<button class="btn btn-link mb-0 px-2 lh-1" id="bd-theme"
						type="button"
						aria-expanded="false"
						data-bs-toggle="dropdown"
						data-bs-display="static">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"  class="bi bi-circle-half theme-icon-active fill-mode fa-fw" viewBox="0 0 16 16">
							<path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
							<use href="#"></use>
						</svg>
						</button>

						<ul class="dropdown-menu min-w-auto dropdown-menu-end" aria-labelledby="bd-theme">
							<li class="mb-1">
								<button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light">
									<svg width="16" height="16" fill="currentColor" class="bi bi-brightness-high-fill fa-fw mode-switch me-1" viewBox="0 0 16 16">
										<path d="M12 8a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
										<use href="#"></use>
									</svg>Light
								</button>
							</li>
							<li class="mb-1">
								<button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon-stars-fill fa-fw mode-switch me-1" viewBox="0 0 16 16">
										<path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
										<path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/>
										<use href="#"></use>
									</svg>Dark
								</button>
							</li>
							<li>
								<button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-half fa-fw mode-switch me-1" viewBox="0 0 16 16">
										<path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
										<use href="#"></use>
									</svg>Auto
								</button>
							</li>
						</ul>
					</li>
					<!-- Dark mode option END -->

					<!-- Schedule button -->
					<li class="nav-item ms-2 d-none d-sm-block" >
						<a href="#" class="btn btn-sm btn-dark mb-0"><i class="bi bi-cloud-download-fill me-2" ></i>Download app</a>
					</li>
					<!-- Responsive navbar toggler -->
					<li class="nav-item">
						<button class="navbar-toggler ms-sm-3 p-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-animation">
								<span></span>
								<span></span>
								<span></span>
							</span>
						</button>
					</li>	
				</ul>

			</div>
		</nav>
		<!-- Logo Nav END -->
	</header>
	<!-- Header END -->
</div> 
<!-- Header END -->

<!-- **************** MAIN CONTENT START **************** -->
<main>

<!-- =======================
Hero START -->
<section class="position-relative overflow-hidden pt-sm-8 pt-lg-9 pb-0">
	<!-- Curve bg -->
	<span>
		<svg class="position-absolute bottom-0 start-0 mb-n1 mb-lg-n4" viewBox="0 0 1920 149" style="enable-background:new 0 0 1920 149; z-index: 4" xml:space="preserve">
			<path class="text-secondary" d="M873.3,37.9C775,19.2,603.7-11.5,433.5,4.4C275.1,19.3,45.1,43.4-12,4.4v121V149l1946-2.6V97.6 c-109.9-35.9-230.6-93.1-468.8-75.4C1260.2,37.3,1089.7,79,873.3,37.9z" fill="currentColor"/>
		</svg>
	</span>

	<!-- Blur decoration -->
	<div class="position-absolute end-0 top-0">
		<img src="core/resources/views/templates/ptc_diamond/home/assets/images/elements/grad-shape/blur-decoration-2.svg" class="opacity-2 blur-9 h-300px rotate-335" alt="Grad shape">
	</div>

	<div class="container position-relative pt-4 pt-sm-0 pb-8 pb-xl-9">
		<div class="row align-items-center">
			<!-- Content -->
			<div class="col-lg-6 mb-6 mb-lg-0 ">
				<h1 class="fw-bold mb-3 mb-md-4 hero-heading fw-bold mb-3 mb-md-4">Turn Every Click <br>Into Cash</h1>
				<p class="lead mb-3 mb-md-4">Trusted by thousands of users worldwide. Start earning in just a few clicks with zero upfront cost

				</p>

				<!-- Buttons -->
				<div class="d-sm-flex mb-4 mb-lg-7">
  <a href="#"> 
    <img 
      src="core/resources/views/templates/ptc_diamond/home/assets/images/elements/google-play.svg" 
      id="installTrigger" 
      class="btn-transition me-4 mb-2 mb-sm-0" 
      width="180" 
      alt="play store"> 
  </a>

  <a href="#"> 
    <img 
      src="core/resources/views/templates/ptc_diamond/home/assets/images/elements/app-store.svg" 
      class="btn-transition" 
      width="180" 
      alt="app-store"> 
  </a>
</div>


				<!-- Review deco -->
				<div class="d-flex align-items-center">
					<!-- Avatar list -->
					<ul class="avatar-group align-items-center justify-content-center mb-0 me-2">
						<li class="avatar avatar-sm">
							<img class="avatar-img rounded-circle" src="core/resources/views/templates/ptc_diamond/home/assets/images/team/01.jpg" alt="avatar">
						</li>
						<li class="avatar avatar-sm">
							<img class="avatar-img rounded-circle" src="core/resources/views/templates/ptc_diamond/home/assets/images/team/02.jpg" alt="avatar">
						</li>
						<li class="avatar avatar-sm">
							<img class="avatar-img rounded-circle" src="core/resources/views/templates/ptc_diamond/home/assets/images/team/03.jpg" alt="avatar">
						</li>
						<li class="avatar avatar-sm">
							<img class="avatar-img rounded-circle" src="core/resources/views/templates/ptc_diamond/home/assets/images/team/04.jpg" alt="avatar">
						</li>
						<li class="avatar avatar-sm">
							<img class="avatar-img rounded-circle" src="core/resources/views/templates/ptc_diamond/home/assets/images/team/05.jpg" alt="avatar">
						</li>
					</ul>

					<p class="heading-color mb-0"><span class="text-primary">5000+</span> users have downloaded our app</p>
				</div>
			</div>

			<!-- Image -->
			<div class="col-sm-9 col-lg-5 col-xxl-4 position-relative mx-auto">
				<!-- Decoration images -->
				<div class="position-absolute start-0 top-0 mt-6 ms-xl-n7 z-index-2 d-none d-sm-block">
					<img src="core/resources/views/templates/ptc_diamond/home/assets/images/mobile-app/deocration-2.jpg" class="aos rounded-3 shadow-primary" data-aos="zoom-in" data-aos-delay="400" data-aos-duration="800" data-aos-easing="ease-in-out" style="height: 80px;" alt="deocration">
				</div>

				<div class="position-absolute top-50 end-0 translate-middle-y me-n6 me-xl-n8 mt-xl-n5 d-none d-sm-block">
					<img src="core/resources/views/templates/ptc_diamond/home/assets/images/mobile-app/deocration-3.jpg" class="aos rounded-3 shadow-primary" data-aos="zoom-in" data-aos-delay="600" data-aos-duration="800" data-aos-easing="ease-in-out" alt="deocration">
				</div>

				<!-- Main image -->
				<img src="core/resources/views/templates/ptc_diamond/home/assets/images/mobile-app/hero.png" class="aos mb-n8 mb-md-n9 mb-xxl-n8" data-aos="fade-up" data-aos-delay="100" data-aos-duration="800" data-aos-easing="ease-in-out" alt="mobile image">
			</div>

		</div>
	</div>
</section>
<!-- =======================
Hero END -->

<!-- =======================
Features and rating START -->
<section class="bg-secondary position-relative overflow-hidden z-index-2 pt-6">
	<div class="container">
		<!-- Title -->
		<div class="inner-container-small text-center mb-4 mb-md-6">
			<h2 class="mb-0">Make more than ever before, Join Us.<span class="text-primary-grad">Signup</span> Now!</h2>
		</div>

		<!-- Features and image -->
		<div class="row g-4 g-lg-5 align-items-lg-center">
			<!-- left side features -->
			<div class="col-md-6 col-lg-4 order-1 pe-5">
				<!-- Item -->
				<div class="aos d-flex justify-content-lg-end mb-4 mb-md-6" data-aos="fade-right" data-aos-delay="100" data-aos-duration="1000" data-aos-easing="ease-in-out">
					<!-- Content -->
					<div class="text-lg-end order-1 ms-3 ms-lg-0 me-lg-3">
						<h6 class="mb-2">Watch-to-Earn System</h6>
						<p class="mb-0">You will earn money by watching ads provided by advertisers. 

						</p>
					</div>
					<!-- Icon -->
					<div class="icon-lg bg-body text-success rounded-circle flex-shrink-0 order-lg-2"><i class="bi bi-cash-stack fa-lg"></i></div>
				</div>

				<!-- Item -->
				<div class="aos d-flex justify-content-lg-end mb-4 mb-md-6" data-aos="fade-right" data-aos-delay="100" data-aos-duration="1000" data-aos-easing="ease-in-out">
					<!-- Content -->
					<div class="text-lg-end order-1 ms-3 ms-lg-0 me-lg-3">
						<h6 class="mb-2">🤝 Referral Program / Commission System</h6>
						<p class="mb-0">You can earn bonuses for referring others.</p>
					</div>
					<!-- Icon -->
					<div class="icon-lg bg-body text-purple rounded-circle flex-shrink-0 order-lg-2"><i class="bi bi-receipt fa-lg"></i></div>
				</div>

				<!-- Item -->
				<div class="aos d-flex justify-content-lg-end" data-aos="fade-right" data-aos-delay="100" data-aos-duration="1000" data-aos-easing="ease-in-out">
					<!-- Content -->
					<div class="text-lg-end order-1 ms-3 ms-lg-0 me-lg-3">
						<h6 class="mb-2"> Ad Posting System for Advertisers</h6>
						<p class="mb-0">We allows advertisers to upload ads for users to watch.</p>
					</div>
					<!-- Icon -->
					<div class="icon-lg bg-body text-warning rounded-circle flex-shrink-0 order-lg-2"><i class="bi bi-bell fa-lg"></i></div>
				</div>
			</div>

			<!-- Image -->
			<div class="col-md-8 col-lg-4 mx-auto order-3 order-lg-2">
				<img src="core/resources/views/templates/ptc_diamond/home/assets/images/mobile-app/feature.png" class="aos" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000" data-aos-easing="ease-in-out" alt="feature mobile">
			</div>

			<!-- Right side features -->
			<div class="col-md-6 col-lg-4 order-2 order-lg-3">
				<!-- Item -->
				<div class="aos d-flex mb-4 mb-md-6" data-aos="fade-left" data-aos-delay="100" data-aos-duration="1000" data-aos-easing="ease-in-out">
					<!-- Icon -->
					<div class="icon-lg bg-body text-info rounded-circle flex-shrink-0"><i class="bi bi-person-vcard fa-lg"></i></div>
					<!-- Content -->
					<div class="ms-3">
						<h6 class="mb-2">User Dashboard with Earnings Summary</h6>
						<p class="mb-0">You will be able to see your Total Watch

							Referral earnings
							
							Withdrawable balance
							
							Plan status</p>
					</div>
				</div>

				<!-- Item -->
				<div class="aos d-flex mb-4 mb-md-6" data-aos="fade-left" data-aos-delay="100" data-aos-duration="1000" data-aos-easing="ease-in-out">
					<!-- Icon -->
					<div class="icon-lg bg-body text-primary rounded-circle flex-shrink-0"><i class="bi bi-gear fa-lg"></i></div>
					<!-- Content -->
					<div class="ms-3">
						<h6 class="mb-2">Withdrawal & Payment Gateway</h6>
						<p class="mb-0">You can request payouts once minimum balance is reached. Bi-weekly Payout</p>
					</div>
				</div>

				<!-- Item -->
				<div class="aos d-flex" data-aos="fade-left" data-aos-delay="100" data-aos-duration="1000" data-aos-easing="ease-in-out">
					<!-- Icon -->
					<div class="icon-lg bg-body text-pink rounded-circle flex-shrink-0"><i class="bi bi-headset fa-lg"></i></div>
					<!-- Content -->
					<div class="ms-3">
						<h6 class="mb-2">24/7 customer support</h6>
						<p class="mb-0">Get help anytime with our dedicated customer support team, available around the clock.</p>
					</div>
				</div>
			</div>
		</div>

		<!-- Ratings -->
		<div class="inner-container row g-4 mt-6 mt-md-8" data-aos="zoom-in" data-aos-delay="100" data-aos-duration="1000" data-aos-easing="ease-in-out">
			<!-- Rating number -->
			<div class="col-sm-6 col-md-4">
				<div class="text-center border-end pe-sm-5 h-100">
					<img src="core/resources/views/templates/ptc_diamond/home/assets/images/elements/review.svg" class="h-60px mb-4" alt="review image">
					<h4>4.5/5.0</h4>
					<p class="mb-0">Rating by 365 users</p>
				</div>
			</div>

			<!-- platform rating number -->
			<div class="col-sm-6 col-md-4">
				<div class="text-center border-end pe-sm-5 h-100">
					<div class="d-flex justify-content-center gap-2 mb-4">
						<img src="core/resources/views/templates/ptc_diamond/home/assets/images/elements/apple.svg" class="h-60px" alt="">
						<img src="core/resources/views/templates/ptc_diamond/home/assets/images/elements/play-store.svg" class="h-60px" alt="">
					</div>
					<h4>35K+</h4>
					<p class="mb-0">Review on google play and iOS</p>
				</div>
			</div>

			<!-- platform rating number -->
			<div class="col-md-4">
				<div class="text-center h-100">
					<span class="display-6 text-primary-grad"><i class="bi bi-people"></i></span>
					<h4>1.5M</h4>
					<p class="mb-0">Total members use this platform</p>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- =======================
Features and rating END -->

<!-- =======================
Steps START -->
<section>
	<div class="container">
		<div class="row g-4 align-items-lg-center">
			<!-- Images -->
			<div class="col-md-6 col-xl-5 order-2 order-md-1">
				<div class="swiper" data-swiper-options='{
					"spaceBetween": 30,
					"effect": "fade",
					"autoplay":false,
					"simulateTouch":false,
					"navigation":{
						"nextEl":".swiper-button-next-steps",
						"prevEl":".swiper-button-prev-steps"
					}}'>
						
					<div class="swiper-wrapper">
						<!-- Testimonials item -->
						<div class="swiper-slide bg-body">
							<div class="bg-secondary-grad rounded-4 overflow-hidden p-5 h-100">
								<img src="core/resources/views/templates/ptc_diamond/home/assets/images/mobile-app/step-1.png" class="mb-n8 rounded-5 shadow-primary" alt="step image">
							</div>
						</div>

						<!-- Testimonials item -->
						<div class="swiper-slide bg-body">
							<div class="bg-secondary-grad rounded-4 overflow-hidden p-5 h-100">
								<img src="assets/images/mobile-app/step-2.png" class="mb-n8 rounded-5 shadow-primary" alt="step image">
							</div>
						</div>

						<!-- Testimonials item -->
						<div class="swiper-slide bg-body">
							<div class="bg-secondary-grad rounded-4 overflow-hidden p-5 h-100">
								<img src="core/resources/views/templates/ptc_diamond/home/assets/images/mobile-app/step-3.png" class="mb-n8 rounded-5 shadow-primary" alt="step image">
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Steps Content START -->
			<div class="col-md-6 order-1 ms-auto">		
				<!-- Slider START -->
				<div class="swiper" data-swiper-options='{
					"spaceBetween": 30,
					"autoplay":false,
					"simulateTouch":false,
					"navigation":{
						"nextEl":".swiper-button-next-steps",
						"prevEl":".swiper-button-prev-steps"
					}}'>
					
					<div class="swiper-wrapper mb-lg-5">
						<!-- Testimonials item -->
						<div class="swiper-slide">
							<span class="fw-semibold text-primary">Phase 1</span>
							<h2 class="my-3">Sign up and secure your account</h2>
							<p class="mb-0">Create an account using your email or phone number. Complete the straightforward verification process to ensure your account is protected. Follow the simple verification process to secure your account. This ensures a personalized and seamless app experience.</p>
						</div>

						<!-- Testimonials item -->
						<div class="swiper-slide">
							<span class="fw-semibold text-primary">Phase 2</span>
							<h2 class="my-3">Enter your personal details</h2>
							<p class="mb-0">Provide the necessary information to set up your profile. This ensures a personalized and seamless experience tailored to your needs. This ensures a personalized and seamless experience.</p>
						</div>

						<!-- Testimonials item -->
						<div class="swiper-slide">
							<span class="fw-semibold text-primary">Phase 3</span>
							<h2 class="my-3">Explore the full range of Adsnoval features</h2>
							<p class="mb-0">Unlock powerful tools that drive traffic, boost earnings, and grow your ad revenue. From ad watch to referrals, see how every feature helps you earn smarter.</p>
						</div>
					</div>
				</div>		
				<!-- Slider END -->
				 
				<!-- Slider arrow -->
				<div class="d-flex gap-3 position-relative mt-3">
					<a href="#" class="btn btn-lg btn-secondary btn-icon rounded-circle mb-0 swiper-button-prev-steps rtl-flip"><i class="bi bi-arrow-left"></i></a>
					<a href="#" class="btn btn-lg btn-secondary btn-icon rounded-circle mb-0 swiper-button-next-steps rtl-flip"><i class="bi bi-arrow-right"></i></a>
				</div>
			</div>
			<!-- Steps Content END -->
		</div>
	</div>
</section>
<!-- =======================
Steps END -->

<!-- =======================
Left right feature START -->
<section class="overflow-hidden pt-0">
	<div class="container">
		<div class="row align-items-lg-center">
			<!-- Content -->
			<div class="col-md-6">
				<!-- Title -->
				<h2 class="mb-lg-3">Experience the future of ad revenue today</h2>
				<!-- List -->
				<ul class="list-group list-group-borderless mb-0">
					<li class="list-group-item d-flex fw-semibold pb-0"><i class="bi bi-check-circle text-primary me-2"></i>Convenience at your fingertips</li>
					<li class="list-group-item d-flex fw-semibold pb-0"><i class="bi bi-check-circle text-primary me-2"></i>Enhanced security</li>
					<li class="list-group-item d-flex fw-semibold pb-0"><i class="bi bi-check-circle text-primary me-2"></i>Comprehensive financial tools</li>
				</ul>

				<hr class="my-4"> <!-- Divider -->

				<!-- Skill sets -->
				<div class="row">
					<!-- Item -->
					<div class="col-lg-5">
						<div class="d-flex align-items-center mb-4">
							<div class="w-40px h-100 me-4 me-sm-5 flex-shrink-0">
								<div class="d-flex">
									<h4 class="purecounter mb-0" data-purecounter-start="0" data-purecounter-end="98"	data-purecounter-delay="300">0</h4>
									<span class="h4 text-pink mb-0">%</span>
								</div>
							</div>
							<p class="mb-0">Customer satisfaction rate</p>
						</div>
					</div>

					<!-- Item -->
					<div class="col-lg-5">
						<div class="d-flex align-items-center mb-4">
							<div class="w-40px h-100 me-4 me-sm-5 flex-shrink-0">
								<div class="d-flex">
									<h4 class="purecounter mb-0" data-purecounter-start="0" data-purecounter-end="60"	data-purecounter-delay="300">0</h4>
									<span class="h4 text-success mb-0">+</span>
								</div>
							</div>
							<p class="mb-0">Serving countries worldwide</p>
						</div>
					</div>
				</div>
			</div>

			<!-- Image -->
			<div class="col-md-6 col-lg-5 position-relative ms-auto">
				<img src="core/resources/views/templates/ptc_diamond/home/assets/images/mobile-app/01.jpg" class="rounded-4" alt="feature image">
				<!-- Rocket image -->
				<div class="position-absolute start-0 top-0 ms-n6 d-none d-lg-block">
					<img src="core/resources/views/templates/ptc_diamond/home/assets/images/elements/rocket-03.png" class="h-150px" alt="rocket image">
				</div>
				<!-- Decoration -->
				<div class="position-absolute bottom-0 end-0 me-lg-n5 mb-lg-n3">
					<img src="core/resources/views/templates/ptc_diamond/home/assets/images/mobile-app/deocration.jpg" class="shadow rounded-3 h-lg-70px" alt="decoration image">
				 </div>
			</div>
		</div>
	</div>
</section>
<!-- =======================
Left right feature END -->

<!-- =======================
Screen gallery and feature START -->
<section class="position-relative z-index-2 py-0" data-bs-theme="dark">
	<div class="container-fluid position-relative">
		<div class="max-width-1550 bg-dark position-relative rounded-4 overflow-hidden py-6 py-lg-8">
			<!-- Grad blur -->
			<div class="position-absolute top-0 end-0 mt-n6">
				<img src="core/resources/views/templates/ptc_diamond/home/assets/images/elements/grad-shape/blur-decoration.svg" class="rotate-270 blur-8 opacity-2" alt="Grad shape">
			</div>
			
			<!-- Title and content -->
			<div class="container inner-container-small text-center mb-7">
				<h2 class="mb-4">Get a closer look at how our app works</h2>
				<p class="mb-4"> Browse through our gallery to get a glimpse of the intuitive design and powerful features that make managing your earnings effortless.</p>
				<div class="d-sm-flex justify-content-center">
  <a href="#">
    <img 
      src="core/resources/views/templates/ptc_diamond/home/assets/images/elements/google-play.svg" 
      id="installTrigger"
      class="btn-transition me-sm-4 mb-2 mb-sm-0" 
      width="180" 
      alt="play store">
  </a>
					<a href="#"> <img src="core/resources/views/templates/ptc_diamond/home/assets/images/elements/app-store.svg" class="btn-transition" width="180" alt="app-store"> </a>
				</div>
			</div>

			<!-- Slider START -->
			<div class="swiper swiper-outside-n5 pb-6 mx-3 mx-sm-0" data-swiper-options='{
				"slidesPerView": 1, 
				"spaceBetween": 50,
				"autoplay":{
					"delay": 2000, 
					"disableOnInteraction": false,
					"pauseOnMouseEnter": true
				},
				"breakpoints": { 
					"576": {"slidesPerView": 3}, 
					"992": {"slidesPerView": 5},
					"1300": {"slidesPerView": 7}
				},
				"pagination":{
					"el":".swiper-pagination",
					"clickable":"true"
				}}'>

				<!-- Slider items -->
				<div class="swiper-wrapper align-items-center">
					<!-- Image -->
					<div class="swiper-slide">
						<img src="core/resources/views/templates/ptc_diamond/home/assets/images/mobile-app/screen/s-01.png" class="rounded-4 border border-secondary border-3" alt="mobile screen">
					</div>

					<!-- Image -->
					<div class="swiper-slide">
						<img src="core/resources/views/templates/ptc_diamond/home/assets/images/mobile-app/screen/s-02.png" class="rounded-4 border border-secondary border-3" alt="mobile screen">
					</div>

					<!-- Image -->
					<div class="swiper-slide">
						<img src="core/resources/views/templates/ptc_diamond/home/assets/images/mobile-app/screen/s-03.png" class="rounded-4 border border-secondary border-3" alt="mobile screen">
					</div>

					<!-- Image -->
					<div class="swiper-slide">
						<img src="core/resources/views/templates/ptc_diamond/home/assets/images/mobile-app/screen/s-04.png" class="rounded-4 border border-secondary border-3" alt="mobile screen">
					</div>

					<!-- Image -->
					<div class="swiper-slide">
						<img src="core/resources/views/templates/ptc_diamond/home/assets/images/mobile-app/screen/s-05.png" class="rounded-4 border border-secondary border-3" alt="mobile screen">
					</div>

					<!-- Image -->
					<div class="swiper-slide">
						<img src="core/resources/views/templates/ptc_diamond/home/assets/images/mobile-app/screen/s-06.png" class="rounded-4 border border-secondary border-3" alt="mobile screen">
					</div>

					<!-- Image -->
					<div class="swiper-slide">
						<img src="core/resources/views/templates/ptc_diamond/home/assets/images/mobile-app/screen/s-07.png" class="rounded-4 border border-secondary border-3" alt="mobile screen">
					</div>

					<!-- Image -->
					<div class="swiper-slide">
						<img src="core/resources/views/templates/ptc_diamond/home/assets/images/mobile-app/screen/s-08.png" class="rounded-4 border border-secondary border-3" alt="mobile screen">
					</div>
				</div>

				<!-- Slider Pagination -->
				<div class="swiper-pagination swiper-pagination-primary position-absolute bottom-0 mb-4"></div>
			</div>	
			<!-- Slider END	 -->
		</div>
	</div>
</section>
<!-- =======================
Screen gallery and feature END -->

<!-- =======================
Testimonials START -->
<section>
	<div class="container">
		<div class="row align-items-center">
			<!-- Title and slider button -->
			<div class="col-lg-4 text-center text-lg-start">
				<h2 class="mb-3 mb-lg-4">Hear from our satisfied users</h2>
				<!-- Rating -->
				<ul class="avatar-group align-items-center justify-content-center justify-content-lg-start mb-2">
					<li class="avatar avatar-sm">
						<img class="avatar-img rounded-circle" src="core/resources/views/templates/ptc_diamond/home/assets/images/team/01.jpg" alt="avatar">
					</li>
					<li class="avatar avatar-sm">
						<img class="avatar-img rounded-circle" src="core/resources/views/templates/ptc_diamond/home/assets/images/team/02.jpg" alt="avatar">
					</li>
					<li class="avatar avatar-sm">
						<img class="avatar-img rounded-circle" src="core/resources/views/templates/ptc_diamond/home/assets/images/team/03.jpg" alt="avatar">
					</li>
					<li class="avatar avatar-sm">
						<img class="avatar-img rounded-circle" src="core/resources/views/templates/ptc_diamond/home/assets/images/team/04.jpg" alt="avatar">
					</li>
					<li class="avatar avatar-sm">
						<img class="avatar-img rounded-circle" src="core/resources/views/templates/ptc_diamond/home/assets/images/team/05.jpg" alt="avatar">
					</li>
				</ul>
				<p>Rated <span class="badge bg-dark">4.9/5.0</span> by over 100.000+ users</p>
			</div>

			<div class="col-lg-8 col-xl-7 ms-auto">
				<!-- Slider START -->
				<div class="swiper mt-2 mt-md-4" data-swiper-options='{
					"spaceBetween": 30,
					"autoplay":{
						"delay": 4000, 
						"disableOnInteraction": false,
						"pauseOnMouseEnter": true
					},
					"navigation":{
						"nextEl":".swiper-button-next-test",
						"prevEl":".swiper-button-prev-test"
					}}'>
					
					<div class="swiper-wrapper">
						<!-- Testimonial item -->
						 <div class="swiper-slide">
							<div class="card bg-secondary bg-opacity-50 rounded-4 overflow-hidden">
								<div class="row g-0">
									<div class="col-md-5">
										<!-- Image -->
										<img src="core/resources/views/templates/ptc_diamond/home/assets/images/team/01.jpg" class="rounded-start mb-3 mb-md-0" alt="...">
									</div>
									<div class="col-md-7 col-xl-6">
										<!-- Content -->
										<div class="card-body d-flex flex-column h-100 p-xl-4">
											<!-- Rating star -->
											<ul class="list-inline mb-2">
												<li class="list-inline-item me-0"><i class="bi bi-star-fill text-primary"></i></li>
												<li class="list-inline-item me-0"><i class="bi bi-star-fill text-primary"></i></li>
												<li class="list-inline-item me-0"><i class="bi bi-star-fill text-primary"></i></li>
												<li class="list-inline-item me-0"><i class="bi bi-star-fill text-primary"></i></li>
												<li class="list-inline-item me-0"><i class="bi bi-star-half text-primary"></i></li>
											</ul>
											<p class="heading-color">I went from making pennies to stacking commissions daily. The referral system and ad watch rewards are super clean and reliable. Highly recommend!</p>
			
											<!-- Info -->
											<div class="mt-auto">
												<p class="lead heading-color fw-semibold mb-0">— Jessica M.</p>
												<small>Affiliate Marketer</small>
											</div>
			
										</div>
									</div>
								</div>
							</div>
						 </div>

						<!-- Testimonial item -->
						<div class="swiper-slide">
							<div class="card bg-secondary bg-opacity-50 rounded-4 overflow-hidden">
								<div class="row g-0">
									<div class="col-md-5">
										<!-- Image -->
										<img src="core/resources/views/templates/ptc_diamond/home/assets/images/team/04.jpg" class="rounded-start mb-3 mb-md-0" alt="...">
									</div>
									<div class="col-md-7 col-xl-6">
										<!-- Content -->
										<div class="card-body d-flex flex-column h-100 p-xl-4">
											<!-- Rating star -->
											<ul class="list-inline mb-2">
												<li class="list-inline-item me-0"><i class="bi bi-star-fill text-primary"></i></li>
												<li class="list-inline-item me-0"><i class="bi bi-star-fill text-primary"></i></li>
												<li class="list-inline-item me-0"><i class="bi bi-star-fill text-primary"></i></li>
												<li class="list-inline-item me-0"><i class="bi bi-star-fill text-primary"></i></li>
												<li class="list-inline-item me-0"><i class="bi bi-star-half text-primary"></i></li>
											</ul>
											<p class="heading-color">I've tried a few PPC sites, but AdsNoval stands out. Transparent tracking, easy withdrawals, 
												and solid support. Just one feature I hope they add is daily bonuses.</p>
			
											<!-- Info -->
											<div class="mt-auto">
												<p class="lead heading-color fw-semibold mb-0"> Kelvin T.</p>
												<small>University Student</small>
											</div>
			
										</div>
									</div>
								</div>
							</div>
						</div>	

						<!-- Testimonial item -->
						<div class="swiper-slide">
							<div class="card bg-secondary bg-opacity-50 rounded-4 overflow-hidden">
								<div class="row g-0">
									<div class="col-md-5">
										<!-- Image -->
										<img src="core/resources/views/templates/ptc_diamond/home/assets/images/team/03.jpg" class="rounded-start mb-3 mb-md-0" alt="...">
									</div>
									<div class="col-md-7 col-xl-6">
										<!-- Content -->
										<div class="card-body d-flex flex-column h-100 p-xl-4">
											<!-- Rating star -->
											<ul class="list-inline mb-2">
												<li class="list-inline-item me-0"><i class="bi bi-star-fill text-primary"></i></li>
												<li class="list-inline-item me-0"><i class="bi bi-star-fill text-primary"></i></li>
												<li class="list-inline-item me-0"><i class="bi bi-star-fill text-primary"></i></li>
												<li class="list-inline-item me-0"><i class="bi bi-star-fill text-primary"></i></li>
												<li class="list-inline-item me-0"><i class="bi bi-star-fill text-primary"></i></li>
											</ul>
											<p class="heading-color">At first, I wasn’t sure, but AdsNoval proved me wrong. The earnings from ad watch + referrals are real. Super beginner-friendly too!</p>
			
											<!-- Info -->
											<div class="mt-auto">
												<p class="lead heading-color fw-semibold mb-0"> Amina R.</p>
												<small>Stay-at-home Mom</small>
											</div>
			
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>

					<!-- Slider arrow -->
					<div class="d-flex justify-content-between position-absolute top-50 start-50 translate-middle w-100 z-index-2">
						<a href="#" class="btn btn-dark btn-icon btn-lg rounded-circle mb-0 swiper-button-prev-test rtl-flip ms-2"><i class="bi bi-arrow-left"></i></a>
						<a href="#" class="btn btn-dark btn-icon btn-lg rounded-circle mb-0 swiper-button-next-test rtl-flip me-2"><i class="bi bi-arrow-right"></i></a>
					</div>
				</div>		
				<!-- Slider END -->
			</div>
		</div> <!-- Row END -->
	</div>
</section>
<!-- =======================
Testimonials END -->



<!-- =======================
CTA START -->
<section class="bg-secondary-grad position-relative overflow-hidden py-7">
	<div class="container">
		<div class="row g-4 align-items-center">
			<!-- Content -->
			<div class="col-md-6">
				<!-- Title -->
				<h2 class="mb-4">Start Earning with Every Click</h2>
				<p class="mb-4">Join thousands who are turning their time into real income on AdsNoval.</p>
				<!-- Buttons -->
				<div class="d-sm-flex">
  <a href="#">
    <img 
      src="core/resources/views/templates/ptc_diamond/home/assets/images/elements/google-play.svg" 
      id="installTrigger"
      class="btn-transition me-4 mb-2 mb-sm-0" 
      width="150" 
      alt="play store">
  </a>
					<a href="#"> <img src="core/resources/views/templates/ptc_diamond/home/assets/images/elements/app-store.svg" class="btn-transition" width="150" alt="app-store"> </a>
				</div>
			</div>

			<!-- Image -->
			<div class="col-sm-9 col-md-6 mx-auto mb-n9">
				<img src="core/resources/views/templates/ptc_diamond/home/assets/images/mobile-app/cta.png" class="aos mb-n5 mb-lg-n9 ms-lg-5" data-aos="fade-up" data-aos-delay="200" data-aos-duration="500" data-aos-easing="ease-in-out" alt="cta image">
			</div>
		</div>
	</div>
</section>
<!-- =======================
CTA END -->

</main>
<!-- ============ New Features (AdsNoval) ============ -->
<section class="nf-section">
    <div class="container">
        <div class="nf-head">
            <span class="nf-chip">✨ @lang('New')</span>
            <h2 class="nf-title">@lang('More ways to earn, every single day')</h2>
            <p class="nf-sub">@lang('We just launched three new features that reward you for showing up and having fun.')</p>
        </div>

        <div class="nf-grid">
            <!-- Spin the Wheel -->
            <div class="nf-card">
                <div class="nf-card__visual">
                    <div class="nf-wheel"></div>
                    <div class="nf-wheel__hub">SPIN</div>
                </div>
                <div class="nf-badge">🎡 @lang('Daily Spin')</div>
                <h3 class="nf-card__title">@lang('Spin the Wheel')</h3>
                <p class="nf-card__text">@lang('Claim a free spin every day for a shot at instant cash prizes — and a free ad every few spins.')</p>
            </div>

            <!-- Daily Streak -->
            <div class="nf-card">
                <div class="nf-card__visual nf-card__visual--streak">
                    <div class="nf-streak">
                        <span class="on">1</span><span class="on">2</span><span class="on">3</span><span>4</span><span>5</span><span>6</span><span>7</span>
                    </div>
                    <div class="nf-fire">🔥</div>
                </div>
                <div class="nf-badge">🔥 @lang('Login Streak')</div>
                <h3 class="nf-card__title">@lang('Daily Login Streak')</h3>
                <p class="nf-card__text">@lang('Check in every day to keep your streak alive. The longer your streak, the bigger your daily bonus grows.')</p>
            </div>

            <!-- Live Payouts -->
            <div class="nf-card">
                <div class="nf-card__visual nf-card__visual--live">
                    <div class="nf-pay"><span class="nf-pay__av">B</span><span class="nf-pay__t">b***84<small>Bitcoin</small></span><span class="nf-pay__amt">$1,204</span></div>
                    <div class="nf-pay"><span class="nf-pay__av">S</span><span class="nf-pay__t">s***21<small>USDT</small></span><span class="nf-pay__amt">$318</span></div>
                    <div class="nf-pay"><span class="nf-pay__av">J</span><span class="nf-pay__t">j***09<small>Solana</small></span><span class="nf-pay__amt">$76</span></div>
                </div>
                <div class="nf-badge">💸 @lang('Live')</div>
                <h3 class="nf-card__title">@lang('Live Payouts Feed')</h3>
                <p class="nf-card__text">@lang('Watch real members get paid in real time. Full transparency — see the money moving as it happens.')</p>
            </div>
        </div>

        <div class="nf-cta">
            <a href="{{ route('user.register') }}" class="nf-cta__btn">@lang('Start Earning Free') →</a>
        </div>
    </div>
</section>

<style>
.nf-section { padding: 96px 0; background: radial-gradient(700px 360px at 15% 0%, rgba(249,115,22,.14), transparent 60%), #0a0e1a; color: #e8edf9; }
.nf-head { text-align: center; max-width: 640px; margin: 0 auto 50px; }
.nf-chip { display: inline-block; padding: 7px 16px; border-radius: 999px; background: linear-gradient(135deg, rgba(124,58,237,.2), rgba(249,115,22,.2)); border: 1px solid rgba(255,255,255,.12); font-weight: 700; font-size: 13px; color: #ff9142; }
.nf-title { font-size: 40px; font-weight: 900; margin: 18px 0 10px; letter-spacing: -.02em; background: linear-gradient(120deg,#fff,#ffd0a8 50%,#ff9142); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }
.nf-sub { color: #8b96ab; font-size: 17px; }
.nf-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 22px; }
@media (max-width: 900px){ .nf-grid { grid-template-columns: 1fr; max-width: 460px; margin: 0 auto; } .nf-title { font-size: 30px; } .nf-section{padding:64px 0;} }
.nf-card {
    background: linear-gradient(180deg,#141b2d,#1a2236); border: 1px solid rgba(255,255,255,.08);
    border-radius: 22px; padding: 26px; text-align: center; position: relative; overflow: hidden;
    box-shadow: 0 30px 60px -34px rgba(0,0,0,.9); transition: transform .25s ease, border-color .25s ease;
}
.nf-card:hover { transform: translateY(-6px); border-color: rgba(124,58,237,.45); }
.nf-card__visual { height: 150px; display: grid; place-items: center; position: relative; margin-bottom: 18px; }
.nf-wheel { width: 132px; height: 132px; border-radius: 50%; border: 6px solid rgba(255,255,255,.08); box-shadow: 0 0 0 5px rgba(124,58,237,.25); background: conic-gradient(#4f2ea8 0 45deg,#1f2b52 45deg 90deg,#3a1e6e 90deg 135deg,#173a52 135deg 180deg,#5a2ea8 180deg 225deg,#204a63 225deg 270deg,#2a1f5e 270deg 315deg,#173a52 315deg 360deg); animation: nf-spin 9s linear infinite; }
@keyframes nf-spin { to { transform: rotate(360deg); } }
.nf-wheel__hub { position: absolute; width: 50px; height: 50px; border-radius: 50%; display: grid; place-items: center; font-size: 11px; font-weight: 800; color: #fff; background: var(--nv-grad); border: 3px solid rgba(255,255,255,.25); box-shadow: 0 0 20px rgba(124,58,237,.7); }
.nf-streak { display: flex; gap: 7px; }
.nf-streak span { width: 30px; height: 40px; border-radius: 9px; display: grid; place-items: center; font-weight: 800; font-size: 13px; color: #8b96ab; background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08); }
.nf-streak span.on { background: var(--nv-grad); color: #fff; border: none; box-shadow: 0 8px 18px -10px rgba(124,58,237,.9); }
.nf-fire { position: absolute; top: 6px; right: 30px; font-size: 26px; filter: drop-shadow(0 0 10px rgba(251,146,60,.6)); }
.nf-card__visual--live { flex-direction: column; gap: 8px; display: flex; justify-content: center; width: 100%; }
.nf-pay { display: flex; align-items: center; gap: 10px; width: 100%; max-width: 240px; margin: 0 auto; padding: 8px 12px; border-radius: 11px; background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.07); }
.nf-pay__av { width: 26px; height: 26px; border-radius: 50%; display: grid; place-items: center; font-size: 12px; font-weight: 800; color: #ff9142; background: linear-gradient(135deg,rgba(124,58,237,.3),rgba(249,115,22,.3)); }
.nf-pay__t { flex: 1; text-align: left; font-weight: 700; font-size: 13px; line-height: 1.1; }
.nf-pay__t small { display: block; color: #8b96ab; font-weight: 500; font-size: 11px; }
.nf-pay__amt { font-weight: 800; color: #34d399; font-size: 13px; }
.nf-badge { display: inline-block; padding: 5px 12px; border-radius: 999px; background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.1); font-size: 12px; font-weight: 700; color: #ff9142; margin-bottom: 12px; }
.nf-card__title { font-size: 21px; font-weight: 800; margin: 0 0 8px; color: #fff; }
.nf-card__text { color: #8b96ab; font-size: 14.5px; margin: 0; }
.nf-cta { text-align: center; margin-top: 44px; }
.nf-cta__btn { display: inline-block; padding: 16px 34px; border-radius: 14px; background: var(--nv-grad); color: #fff !important; font-weight: 800; text-decoration: none; box-shadow: 0 16px 34px -16px rgba(124,58,237,.9); transition: .2s; }
.nf-cta__btn:hover { filter: brightness(1.08); transform: translateY(-2px); }
</style>
<!-- ============ End New Features ============ -->

<!-- ============ Earnings Calculator + Live Payouts (AdsNoval) ============ -->
<section class="av-earn">
    <div class="container">
        <div class="av-earn__head">
            <span class="av-chip">💸 @lang('Earnings Estimator')</span>
            <h2 class="av-earn__title">@lang('See how much you could earn')</h2>
            <p class="av-earn__sub">@lang('Pick a plan, drag the slider, and watch your potential daily & monthly income update instantly.')</p>
        </div>

        <div class="row g-4 align-items-stretch">
            <!-- Calculator -->
            <div class="col-lg-7">
                <div class="av-card">
                    <div class="av-field">
                        <label>@lang('Choose a plan')</label>
                        <select id="avPlan" class="av-input"></select>
                    </div>

                    <div class="av-field">
                        <div class="av-slider-head">
                            <label>@lang('Ads watched per day')</label>
                            <span id="avAdsVal" class="av-pill">0</span>
                        </div>
                        <input type="range" id="avAds" min="0" max="50" value="20" class="av-range">
                    </div>

                    <div class="av-field">
                        <div class="av-slider-head">
                            <label>@lang('Active referrals')</label>
                            <span id="avRefVal" class="av-pill">5</span>
                        </div>
                        <input type="range" id="avRef" min="0" max="200" value="5" class="av-range">
                    </div>

                    <div class="av-results">
                        <div class="av-result">
                            <span class="av-result__label">@lang('Per Day')</span>
                            <span class="av-result__val" id="avDaily">{{ gs('cur_sym') }}0.00</span>
                        </div>
                        <div class="av-result av-result--hl">
                            <span class="av-result__label">@lang('Per Month')</span>
                            <span class="av-result__val" id="avMonthly">{{ gs('cur_sym') }}0.00</span>
                        </div>
                        <div class="av-result">
                            <span class="av-result__label">@lang('Per Year')</span>
                            <span class="av-result__val" id="avYearly">{{ gs('cur_sym') }}0.00</span>
                        </div>
                    </div>

                    <a href="{{ route('user.register') }}" class="av-cta">@lang('Start Earning Free') →</a>
                    <p class="av-disc">@lang('Illustrative estimate based on average payouts. Actual earnings vary.')</p>
                </div>
            </div>

            <!-- Live payouts -->
            <div class="col-lg-5">
                <div class="av-card av-card--live">
                    <div class="av-live__head">
                        <span class="av-live__dot"></span>
                        <span>@lang('Live Payouts')</span>
                        <span class="av-live__total" id="avTotal"></span>
                    </div>
                    <ul class="av-live__list" id="avFeed">
                        <li class="av-live__item av-muted">@lang('Loading recent payouts…')</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.av-earn { padding: 90px 0; background: radial-gradient(800px 400px at 80% 0%, rgba(124,58,237,.18), transparent 60%), #0a0e1a; color: #e8edf9; }
.av-earn__head { text-align: center; max-width: 640px; margin: 0 auto 44px; }
.av-chip { display: inline-block; padding: 7px 16px; border-radius: 999px; background: linear-gradient(135deg, rgba(124,58,237,.2), rgba(249,115,22,.2)); border: 1px solid rgba(255,255,255,.12); font-weight: 700; font-size: 13px; color: #ff9142; }
.av-earn__title { font-size: 40px; font-weight: 900; margin: 18px 0 10px; letter-spacing: -.02em; background: linear-gradient(120deg,#fff,#ffd0a8 50%,#ff9142); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }
.av-earn__sub { color: #8b96ab; font-size: 17px; }
.av-card { background: linear-gradient(180deg,#141b2d,#1a2236); border: 1px solid rgba(255,255,255,.08); border-radius: 22px; padding: 30px; height: 100%; box-shadow: 0 30px 60px -34px rgba(0,0,0,.9); }
.av-field { margin-bottom: 22px; }
.av-field label { display: block; font-weight: 700; margin-bottom: 10px; color: #e8edf9; }
.av-input { width: 100%; padding: 14px 16px; border-radius: 12px; background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.12); color: #fff; font-size: 15px; }
.av-input option { background: #141b2d; }
.av-slider-head { display: flex; justify-content: space-between; align-items: center; }
.av-pill { background: linear-gradient(135deg,#7c3aed,#f97316); color: #fff; font-weight: 800; padding: 3px 12px; border-radius: 999px; font-size: 13px; }
.av-range { width: 100%; -webkit-appearance: none; height: 8px; border-radius: 999px; background: linear-gradient(90deg,#7c3aed,#ff9142); outline: none; margin-top: 6px; }
.av-range::-webkit-slider-thumb { -webkit-appearance: none; width: 22px; height: 22px; border-radius: 50%; background: #fff; cursor: pointer; box-shadow: 0 0 0 4px rgba(124,58,237,.4); }
.av-range::-moz-range-thumb { width: 22px; height: 22px; border: none; border-radius: 50%; background: #fff; cursor: pointer; box-shadow: 0 0 0 4px rgba(124,58,237,.4); }
.av-results { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; margin: 26px 0; }
.av-result { text-align: center; padding: 18px 8px; border-radius: 14px; background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.07); }
.av-result--hl { background: linear-gradient(135deg,rgba(124,58,237,.25),rgba(249,115,22,.25)); border-color: rgba(255,145,66,.4); }
.av-result__label { display: block; font-size: 12px; text-transform: uppercase; letter-spacing: .05em; color: #8b96ab; }
.av-result__val { display: block; font-size: 24px; font-weight: 900; margin-top: 6px; color: #fff; }
.av-cta { display: block; text-align: center; padding: 16px; border-radius: 14px; background: linear-gradient(135deg,#7c3aed,#f97316); color: #fff !important; font-weight: 800; text-decoration: none; box-shadow: 0 16px 34px -16px rgba(124,58,237,.9); transition: .2s; }
.av-cta:hover { filter: brightness(1.08); transform: translateY(-2px); }
.av-disc { text-align: center; color: #6b7488; font-size: 12px; margin: 14px 0 0; }
.av-card--live { display: flex; flex-direction: column; }
.av-live__head { display: flex; align-items: center; gap: 10px; font-weight: 800; margin-bottom: 18px; }
.av-live__dot { width: 10px; height: 10px; border-radius: 50%; background: #34d399; box-shadow: 0 0 0 0 rgba(52,211,153,.7); animation: avpulse 1.6s infinite; }
@keyframes avpulse { 0%{box-shadow:0 0 0 0 rgba(52,211,153,.6);} 70%{box-shadow:0 0 0 10px rgba(52,211,153,0);} 100%{box-shadow:0 0 0 0 rgba(52,211,153,0);} }
.av-live__total { margin-left: auto; font-size: 13px; color: #34d399; font-weight: 800; }
.av-live__list { list-style: none; margin: 0; padding: 0; display: grid; gap: 10px; overflow: hidden; flex: 1; }
.av-live__item { display: flex; align-items: center; justify-content: space-between; padding: 13px 15px; border-radius: 12px; background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.07); animation: avrise .5s ease both; }
@keyframes avrise { from{opacity:0;transform:translateY(8px);} to{opacity:1;transform:none;} }
.av-live__who { display: flex; align-items: center; gap: 10px; font-weight: 700; }
.av-live__avatar { width: 34px; height: 34px; border-radius: 50%; display: grid; place-items: center; background: linear-gradient(135deg,rgba(124,58,237,.3),rgba(249,115,22,.3)); color: #ff9142; font-weight: 800; }
.av-live__meta { font-size: 12px; color: #8b96ab; display: block; }
.av-live__amt { font-weight: 900; color: #34d399; }
.av-muted { color: #8b96ab; }
@media (max-width: 575.98px){ .av-earn__title{font-size:30px;} .av-results{grid-template-columns:1fr;} .av-earn{padding:60px 0;} }
</style>

<script>
(function(){
    var plans = @json($calcPlans);
    var avgClick = {{ (float) ($calcConfig['avg_click_value'] ?? 0.05) }};
    var refBonus = {{ (float) ($calcConfig['referral_bonus'] ?? 0.10) }};
    var sym = @json(gs('cur_sym'));

    var $plan = document.getElementById('avPlan');
    var $ads = document.getElementById('avAds'), $ref = document.getElementById('avRef');
    var $adsV = document.getElementById('avAdsVal'), $refV = document.getElementById('avRefVal');

    (plans || []).forEach(function(p, i){
        var o = document.createElement('option');
        o.value = i; o.textContent = p.name + ' — ' + (p.daily_limit || 0) + ' ' + 'ads/day';
        $plan.appendChild(o);
    });
    if (!plans || !plans.length){ var o=document.createElement('option'); o.textContent='Starter — 20 ads/day'; $plan.appendChild(o); plans=[{daily_limit:20}]; }

    function money(v){ return sym + v.toLocaleString(undefined,{minimumFractionDigits:2,maximumFractionDigits:2}); }
    function calc(){
        var p = plans[$plan.value] || plans[0];
        var cap = parseInt(p.daily_limit) || 20;
        if (parseInt($ads.max) !== cap){ $ads.max = cap; if(parseInt($ads.value)>cap) $ads.value = cap; }
        var ads = parseInt($ads.value), refs = parseInt($ref.value);
        $adsV.textContent = ads; $refV.textContent = refs;
        var daily = ads * avgClick + refs * refBonus;
        document.getElementById('avDaily').textContent = money(daily);
        document.getElementById('avMonthly').textContent = money(daily * 30);
        document.getElementById('avYearly').textContent = money(daily * 365);
    }
    $plan.addEventListener('change', function(){ var p=plans[$plan.value]||plans[0]; $ads.value=Math.min(parseInt($ads.value), parseInt(p.daily_limit)||20); calc(); });
    $ads.addEventListener('input', calc); $ref.addEventListener('input', calc);
    calc();

    // Live payouts feed
    function initials(n){ return (n||'?').substring(0,1).toUpperCase(); }
    function loadFeed(){
        fetch('{{ route('withdraw.feed') }}').then(function(r){return r.json();}).then(function(res){
            if(res.status!=='success'||!res.feed.length) return;
            document.getElementById('avTotal').textContent = '{{ __('Paid') }}: ' + res.total;
            var list = document.getElementById('avFeed'); list.innerHTML='';
            res.feed.slice(0,7).forEach(function(f,i){
                var li=document.createElement('li'); li.className='av-live__item'; li.style.animationDelay=(i*0.05)+'s';
                li.innerHTML='<span class="av-live__who"><span class="av-live__avatar">'+initials(f.user)+'</span><span>'+f.user+'<span class="av-live__meta">'+(f.method||'Withdrawal')+' · '+f.ago+'</span></span></span><span class="av-live__amt">'+f.amount+'</span>';
                list.appendChild(li);
            });
        }).catch(function(){});
    }
    loadFeed(); setInterval(loadFeed, 20000);
})();
</script>
<!-- ============ End Earnings Calculator + Live Payouts ============ -->

<!-- **************** MAIN CONTENT END **************** -->

<!-- =======================
Footer START -->
<footer class="bg-dark pt-6 pt-md-8 position-relative" data-bs-theme="dark">

	<div class="container">
		<div class="row g-4 justify-content-between">
			<!-- Widget 1 START -->
			<div class="col-lg-4">
				<!-- logo -->
				<a href="index.html">
					<img class="h-40px" src="core/resources/views/templates/ptc_diamond/home/assets/images/logo.png" alt="logo">
				</a>

				<p class="my-3 my-lg-4">We are a digital earning platform built to help everyday people make real income online through pay-per-watch advertising and referral programs. </p>
				<!-- Social icon -->
				<ul class="list-inline mb-0">
					<li class="list-inline-item"> <a class="btn btn-xs btn-icon btn-secondary" href="#"><i class="bi bi-facebook lh-base"></i></a> </li>
					<li class="list-inline-item"> <a class="btn btn-xs btn-icon btn-secondary" href="#"><i class="bi bi-instagram lh-base"></i></a> </li>
					<li class="list-inline-item"> <a class="btn btn-xs btn-icon btn-secondary" href="#"><i class="bi bi-twitter-x lh-base"></i></a> </li>
					<li class="list-inline-item"> <a class="btn btn-xs btn-icon btn-secondary" href="#"><i class="bi bi-linkedin lh-base"></i></a> </li>
				</ul>
			</div>
			<!-- Widget 1 END -->

			
		<!-- Divider -->
		<hr class="mt-xl-5 mb-0 opacity-1">

		<!-- Bottom footer -->
		<div class="d-md-flex justify-content-between align-items-center text-center text-lg-start py-4">
			<!-- copyright text -->
			<div class="text-body small mb-3 mb-md-0"> Copyrights ©2025 AdsNoval. </div>
			
			<!-- Policy link -->
			<ul class="nav d-flex justify-content-center gap-1 mb-0">
				<li class="nav-item"><a class="nav-link small py-0" href="/policy/payment-policy">Payment policy</a></li>
				<li class="nav-item"><a class="nav-link small py-0 pe-0" href="/policy/privacy-and-policy">Privacy policy</a></li>
			</ul>
		</div>
	</div>
</footer>
<!-- =======================
Footer END -->

<style>.login-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 24px;
  border-radius: 999px;
  font-size: 14px;
  font-weight: 600;
  text-transform: uppercase;
  background: linear-gradient(135deg, #ff6600, #ff8800);
  color: #fff;
  border: none;
  cursor: pointer;
  text-decoration: none;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.login-btn__icon i {
  font-size: 18px;
  display: inline-block;
  line-height: 1;
}

.login-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(255, 102, 0, 0.4);
}

/* Optional subtle shine effect */
.login-btn::before {
  content: "";
  position: absolute;
  top: 0;
  left: -75%;
  width: 50%;
  height: 100%;
  background: linear-gradient(120deg, transparent, rgba(255,255,255,0.4), transparent);
  transform: skewX(-30deg);
  transition: left 0.5s;
}

.login-btn:hover::before {
  left: 130%;
}


.hero-heading {
  overflow: hidden; /* Ensures text is hidden as it types */
  white-space: nowrap;
  border-right: .15em solid orange; /* Typing cursor */
  animation: typing 3.5s steps(30, end), blink-caret 0.75s step-end infinite;
  font-size: 2.5rem;
}

/* Typing Keyframes */
@keyframes typing {
  from { width: 0 }
  to { width: 100% }
}

/* Cursor Blinking */
@keyframes blink-caret {
  from, to { border-color: transparent }
  50% { border-color: orange; }
}

</style>

<!-- Back to top -->
<div class="back-top"></div>

<!-- Bootstrap JS -->
<script src="core/resources/views/templates/ptc_diamond/home/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<!--Vendors-->
<script src="core/resources/views/templates/ptc_diamond/home/assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="core/resources/views/templates/ptc_diamond/home/assets/vendor/purecounterjs/dist/purecounter_vanilla.js"></script>
<script src="core/resources/views/templates/ptc_diamond/home/assets/vendor/aos/aos.js"></script>

<!-- Theme Functions -->
<script src="core/resources/views/templates/ptc_diamond/home/assets/js/functions.js"></script>



<script>
  let deferredPrompt;

  window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault(); // Prevent automatic prompt
    deferredPrompt = e;

    // Attach the install trigger to your image
    const image = document.getElementById('installTrigger');

    if (image) {
      image.style.cursor = 'pointer'; // Optional: make it feel clickable

      image.addEventListener('click', async () => {
        if (deferredPrompt) {
          deferredPrompt.prompt();
          const result = await deferredPrompt.userChoice;
          console.log('Install prompt result:', result.outcome);

          // Clean up
          deferredPrompt = null;

          // Optional: visually hide the image or change state
          // image.style.display = 'none';
        }
      });
    }
  });

  // Optional: Hide or disable install option once app is installed
  window.addEventListener('appinstalled', () => {
    console.log('App successfully installed!');
    const image = document.getElementById('installTrigger');
    if (image) image.style.display = 'none';
  });
</script>



<script>
  function isIos() {
    return /iphone|ipad|ipod/i.test(navigator.userAgent);
  }

  function isInStandaloneMode() {
    return ('standalone' in window.navigator) && window.navigator.standalone;
  }

  // Show popup only for iOS Safari and if not already installed
  if (isIos() && !isInStandaloneMode()) {
    window.addEventListener('load', () => {
      setTimeout(() => {
        document.getElementById('iosInstallPopup').style.display = 'block';
      }, 2000); // Delay popup by 2 seconds for UX
    });
  }
</script>

<div id="iosInstallPopup" style="display: none; position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%);
width: 90%; max-width: 400px; background: #fff3cd; color: #856404; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.2); z-index: 9999; text-align: center; font-family: sans-serif;">
  <div style="font-size: 16px;">
    📱 To install this app on your iPhone, tap <strong>Share</strong> <span style="font-size: 18px;">📤</span> and then Click <strong>Add to Home Screen</strong>.
  </div>
  <button onclick="document.getElementById('iosInstallPopup').style.display='none'" 
    style="margin-top: 12px; padding: 6px 14px; background: #856404; color: #fff; border: none; border-radius: 6px; cursor: pointer;">
    ✕ Dismiss
  </button>
</div>



<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/680fc290d22d79190b3eba36/1ipup019u';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->



</body>
<!--core/resources/views/templates/ptc_diamond/home-->
<!-- Mirrored from stackbros.in/folio/landing/index-application-showcase.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 22 Apr 2025 12:12:05 GMT -->
</html>