@extends('front.partials.app')
@section('header')
	<title>Home|Adhyayanam IAS</title>
	<meta name="description" content="Default Description">
	<meta name="keywords" content="default, keywords">
	<link rel="canonical" href="{{ url()->current() }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endsection

<style>
	.edu-course-card {
		margin-bottom: 2rem;
		perspective: 1000px;
		/* subtle 3D feel on hover */
	}

	.edu-card {
		background: white;
		border-radius: 1rem;
		/* 16px */
		overflow: hidden;
		box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
		transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
		border: 1px solid #f1f5f9;
	}

	.edu-card:hover {
		transform: translateY(-10px) rotateX(2deg) rotateY(2deg);
		box-shadow: 0 20px 40px rgba(0, 0, 0, 0.14);
	}

	.edu-card-image {
		position: relative;
	}

	.edu-thumbnail {
		width: 100%;
		height: 220px;
		border: 5px solid #ffffff;
		border-radius: 20px;
		overflow: hidden;
		object-fit: cover;
		display: block;
		transition: transform 0.4s ease;
	}

	.edu-card:hover .edu-thumbnail {
		transform: scale(1.06);
	}

	.edu-tag {
		position: absolute;
		top: 10px;
		left: 10px;
		background: #045279;
		color: white;
		padding: 0.4rem 1rem;
		border-radius: 2rem;
		font-size: 10px;
		font-weight: 600;
		box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
		z-index: 10;
	}

	.edu-card-body {
		padding: 15px;
	}

	.edu-meta {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 1rem;
		font-size: 0.95rem;
		color: #64748b;
	}

	.edu-duration .icon {
		margin-right: 0.4rem;
		font-size: 1.1rem;
	}

	.edu-price {
		font-weight: 700;
		font-size: 1.35rem;
		color: #ec4899;
		/* vibrant price color – change to your brand */
	}

	.edu-title {
		height: 55px;
		font-size: 1.4rem;
		line-height: 1.35;
		margin: 0 0 0.75rem;
		font-weight: 700;
		color: #1e293b;
	}

	.edu-title a {
		color: inherit;
		text-decoration: none;
		transition: color 0.2s;
	}

	.edu-title a:hover {
		color: #3b82f6;
	}

	.edu-description {
		height: 52px;
		color: #64748b;
		font-size: 0.975rem;
		line-height: 1.6;
		margin: 0 0 1.5rem;
		display: -webkit-box;
		-webkit-line-clamp: 3;
		-webkit-box-orient: vertical;
		overflow: hidden;
	}

	.edu-actions {
		display: flex;
		flex-direction: row;
		justify-content: space-between;
		gap: 1rem;
		flex-wrap: nowrap;
	}

	.edu-btn {
		padding: 0.5rem .8rem;
		border-radius: 9px;
		font-weight: 600;
		font-size: 0.95rem;
		transition: all 0.3s ease;
		display: inline-flex;
		align-items: center;
		gap: 0.5rem;
		text-decoration: none;
	}

	.edu-btn-primary {
		background: #045279;
		color: white;
		box-shadow: 0 4px 14px rgba(59, 130, 246, 0.25);
	}

	.edu-btn-primary:hover {
		background: #ffffff;
		transform: translateY(-2px);
		box-shadow: 0 8px 20px rgba(59, 130, 246, 0.35);
		border: 2px solid #045279;
	}

	.edu-btn-outline {
		background: transparent;
		border: 2px solid #045279;
		color: #045279;
	}

	.edu-btn-outline:hover {
		background: #045279;
		color: white;
		transform: translateY(-2px);
	}

	/* Responsive adjustments */
	@media (max-width: 640px) {
		.edu-thumbnail {
			height: 180px;
		}

		.edu-title {
			font-size: 1.25rem;
		}
	}

	/* ──────────────────────────────────────────────
		   Modern Study Material Category Cards
		   Clean, Professional EdTech Design – 2025/26 Style
		   ────────────────────────────────────────────── */

	.study-category-card {
		margin-bottom: 2rem;
		height: 100%;
		/* equal height cards in row */
	}

	.study-card-link {
		display: block;
		text-decoration: none;
		color: inherit;
		height: 100%;
	}

	.study-card {
		background: white;
		border-radius: 1rem;
		/* 16px modern rounding */
		overflow: hidden;
		box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
		transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
		height: 100%;
		position: relative;
		border: 1px solid #f1f5f9;
	}

	.study-card:hover {
		transform: translateY(-10px);
		box-shadow: 0 20px 40px rgba(0, 0, 0, 0.14);
	}

	.study-image-wrapper {
		position: relative;
		height: 260px;
		/* consistent height – adjust if needed */
		overflow: hidden;
	}

	.study-image {
		width: 100%;
		height: 100%;
		object-fit: cover;
		/* images crop nicely without distortion */
		display: block;
		transition: transform 0.45s ease;
	}

	.study-card:hover .study-image {
		transform: scale(1.08);
	}

	.study-overlay {
		position: absolute;
		bottom: 0;
		left: 0;
		right: 0;
		background: linear-gradient(to top, rgba(0, 0, 0, 0.75) 0%, rgba(0, 0, 0, 0) 100%);
		padding: 1.5rem 1.25rem 1rem;
		color: white;
		transition: all 0.3s ease;
	}

	.study-title {
		margin: 0;
		font-size: 1.35rem;
		font-weight: 700;
		line-height: 1.3;
		text-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
		/* readability on images */
		transition: transform 0.3s ease;
	}

	.study-card:hover .study-overlay {
		padding-bottom: 1.25rem;
	}

	.study-card:hover .study-title {
		transform: translateY(-4px);
	}

	/* Responsive tweaks */
	@media (max-width: 768px) {
		.study-image-wrapper {
			height: 220px;
		}

		.study-title {
			font-size: 1.2rem;
		}
	}

	@media (max-width: 576px) {
		.study-image-wrapper {
			height: 200px;
		}
	}

	.bg-gradient-dark {
		background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
	}

	.topic-card {
		border: 1px solid #dee2e6;
		transition: all 0.3s ease;
	}

	.topic-card:hover {
		transform: translateY(-5px);
		box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
	}

	.topic-header {
		background: linear-gradient(135deg, #0d6efd, #0a58ca);
		/* same blue highlight */
		min-height: 70px;
		/* consistent header */
	}

	.topic-content {
		background: #f8f9fa;
		/* very light bg for content area */
		scrollbar-width: thin;
	}

	.affair-btn {
		transition: all 0.25s ease;
		border: 1px solid #e0e7ff;
		/* subtle border */
	}

	.affair-btn:hover {
		transform: translateX(5px);
		box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
		background: #e0f2fe !important;
		/* stronger hover pastel */
	}

	.bg-pastel-blue {
		background: #f0f9ff;
		/* very light pastel blue – calming & clickable feel */
	}

	.arrow-right {
		transition: transform 0.3s ease;
	}

	.affair-btn:hover .arrow-right {
		transform: translateX(5px);
	}

	/* Optional: alternate pastel for variety if many items */
	.affair-btn:nth-child(odd) {
		background: #f0fdf4;
		/* soft pastel green alternate */
	}

	.affair-btn:nth-child(odd):hover {
		background: #dcfce7 !important;
	}

	/* Scrollbar styling */
	.topic-content::-webkit-scrollbar {
		width: 6px;
	}

	.topic-content::-webkit-scrollbar-thumb {
		background: #a5b4fc;
		border-radius: 3px;
	}

	.home-section {
		background: #045279;
		padding: 15px 0px;
	}

	.owl-carousel {
		height: 100% !important;
	}

	.home-section .box-shadow {
		border: 3px solid #ddd;
		border-radius: 10px;
		overflow: hidden;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.12);
	}

	.banner-img {
		width: 100%;
		height: 100%;
		object-fit: cover;
	}

	.notice-box {
		border-radius: 10px !important;
		overflow: hidden;
	}

	.notice-header {
		background: #fff;
		padding: 12px 18px;
		border-bottom: 2px solid #ececec;
		display: flex;
		align-items: center;
		gap: 8px;
	}

	.nb-icon {
		font-size: 22px;
	}

	.notice-scroll {
		height: 360px;
		overflow: hidden;
		padding: 15px;
		background: #f8fbff;
	}

	.notice-item {
		background: #e7efff;
		padding: 12px 16px;
		border-radius: 6px;
		margin-bottom: 12px;
		font-size: 15px;
		display: flex;
		justify-content: space-between;
		align-items: center;
		opacity: 1;
		transition: all 0.4s ease-in-out;
	}

	.notice-item.fade-out {
		opacity: 0;
		transform: translateY(-20px);
	}

	.notice-item.fade-in {
		opacity: 0;
		transform: translateY(20px);
	}

	.notice-item.fade-in.active {
		opacity: 1;
		transform: translateY(0px);
	}

	.arrow-link {
		font-size: 16px;
		color: #333;
		text-decoration: none;
		font-weight: bold;
	}

	.arrow-link:hover {
		color: #0066ff;
	}

	/* Footer */
	.notice-footer {
		background: #fff;
		padding: 10px;
		text-align: center;
		border-top: 2px solid #ececec;
	}

	.scroll-btn {
		background: #0066ff;
		color: #fff;
		border: none;
		padding: 4px 12px;
		margin: 0 5px;
		border-radius: 4px;
		font-size: 16px;
		cursor: pointer;
	}

	.scroll-btn:hover {
		background: #004bcc;
	}

	.intro-section {
		background: #f8fbff;
		padding: 70px 30px;
		/*text-align: center;*/
		font-family: 'Poppins', sans-serif;

	}

	.main-heading {
		font-size: 2rem;
		font-weight: 700;
		text-align: center;
		color: #232d3b;
	}

	.sub-heading {
		font-size: 15px;
		color: #6f6f6f;
		max-width: 750px;
		margin: 10px auto 40px;
	}

	/* MAIN CONTAINER */
	.intro-container {
		display: flex;
		gap: 30px;
		margin-top: 40px;
	}

	/* LEFT CARD (COL-4) */
	.intro-left-card {

		width: 32%;
		background: white;
		padding: 14px;
		border-radius: 14px;
		box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
	}

	/* RIGHT CARD (COL-8) */
	.intro-right-card {
		width: 68%;
		/* approx col-8 */
		background: #e7efff;
		padding: 30px;
		border-radius: 14px;
		display: flex;
		justify-content: space-between;
		gap: 30px;
	}

	/* INNER LEFT IN COL-8 */
	.right-content {
		width: 60%;
	}

	/* INNER RIGHT IN COL-8 */
	.right-points {
		width: 40%;
	}

	/* HEADING */
	.intro-left-card h3,
	.right-content h3 {
		font-size: 20px;
		font-weight: 600;
		margin-bottom: 12px;
	}

	/* SUB TEXT */
	.sub {
		font-size: 14px;
		color: #397839;
		margin-bottom: 14px;
		font-weight: 600;
	}

	/* NORMAL TEXT */
	.text {
		font-size: 14px;
		color: #555;
		line-height: 1.6;
		margin-bottom: 20px;
	}

	/* BUTTON */
	.btn-join {
		background: #397839;
		color: white;
		border: none;
		padding: 10px 22px;
		border-radius: 8px;
		cursor: pointer;
		font-size: 14px;
		transition: 0.3s;
	}

	.btn-join:hover {
		background: #2e1d10;
		color: #fff;
	}

	/* BULLET POINT LIST */
	.bullet-points {
		list-style: none;
		padding: 0;
	}





	/* Responsive */
	@media(max-width: 900px) {
		.intro-container {
			flex-direction: column;
		}

		.intro-left-card,
		.intro-right-card {
			width: 100%;
		}

		.intro-right-card {
			flex-direction: column;
		}

	}

	.cta-btn-group1 {
		display: flex;
		gap: 15px;
	}

	/* Basic Button Style */
	.cta-btn1 {
		position: relative;
		padding: 12px 28px;
		border-radius: 8px;
		font-size: 16px;
		font-weight: 600;
		text-decoration: none;
		overflow: hidden;
		border: 2px solid #045279;
		color: #045279;
		transition: color 0.4s ease, transform 0.3s ease;
	}

	/* Buyer Button Base */
	.cta-btn1.buyer {
		border-color: #045279;
		color: #045279;
	}

	/* Seller Button Base */
	.cta-btn1.seller {
		border-color: #045279;
		color: #045279;
	}

	/* Hover Background Fill Effect */
	.cta-btn1::before {
		content: "";
		position: absolute;
		top: 0;
		left: -100%;
		width: 100%;
		height: 100%;
		background: #045279;
		z-index: -1;
		transition: left 0.4s ease;
	}

	/* Hover Effect */
	.cta-btn1:hover::before {
		left: 0;
	}

	.cta-btn1:hover {
		color: #fff;
		transform: translateY(-2px);
	}

	.right-points {
		margin-top: 20px;
	}

	.bullet-points {
		list-style: none;
		padding: 0;
		margin: 0;
	}

	.point-card {
		background: #f8fbff;
		/* Light pastel green */
		padding: 14px 18px;
		margin-bottom: 12px;
		border-radius: 10px;
		font-size: 15px;
		font-weight: 600;
		display: flex;
		align-items: center;
		gap: 12px;
		cursor: pointer;
		border: 1px solid #e1f0e1;
		transition: all 0.3s ease;
	}

	.point-card i {
		color: #1e7c32;
		font-size: 18px;
	}

	/* Hover Effect */
	.point-card:hover {
		background: #e9fbe9;
		transform: translateY(-3px);
		border-color: #1e7c32;
		box-shadow: 0 4px 10px rgba(20, 92, 31, 0.12);
	}

	.course-page-section {
		position: relative;
		padding: 70px 0px 70px !important;
		background-color: #ffffff !important;
	}

	.newtab-wrapper {
		/*text-align: center;*/
		margin-bottom: 25px;
	}

	.newtab-menu {
		display: inline-flex;
		gap: 15px;
		padding: 0;
		list-style: none;
		border-bottom: 2px solid #eee;
	}

	.newtab-item {
		padding: 10px 22px;
		font-size: 16px;
		font-weight: 600;
		cursor: pointer;
		border-radius: 6px 6px 0 0;
		transition: 0.3s ease;
		color: #444;
	}

	.newtab-item:hover {
		background: #f3f7ff;
		color: #045279;
	}

	.newtab-item.active {
		background: #045279;
		color: white;
		border-bottom: 2px solid #045279;
	}

	/* Initially hide all */
	.newtab-content {
		display: none;
	}

	/* First tab visible initially */
	#newtab-all {
		display: block;
	}

	.commission-name {
		width: fit-content;
		font-size: 12px;
		color: gray;
		margin: 0px;
		background: #f8fbff;
		padding: 3px 10px;
		border-radius: 3px;

	}

	.newfeature-featured-section {
		padding: 80px 0;
		background: #f8fbff;
	}

	.newfeature-auto-container {
		max-width: 1200px;
		margin: 0 auto;
		padding: 0 15px;
	}

	.newfeature-inner-container {
		/* optional extra wrapper if needed */
	}

	.newfeature-row {
		display: flex;
		flex-wrap: wrap;
		margin: 0 -15px;
	}

	.newfeature-feature-block {
		padding: 0 15px;
		margin-bottom: 30px;
	}

	.newfeature-inner-box {
		text-align: center;
		padding: 40px 25px;
		background: white;
		border-radius: 16px;
		box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
		transition: all 0.35s ease;
		position: relative;
		overflow: hidden;
	}

	.newfeature-inner-box:hover {
		transform: translateY(-12px);
		box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
	}

	.newfeature-icon {
		width: 90px;
		height: 90px;
		margin: 0 auto 25px;
		background: #e7efff;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.newfeature-icon img {
		width: 50px;
		height: 50px;
		filter: brightness(100) contrast(100);
		/* makes icon white if it's dark */
	}

	.newfeature-inner-box h4 {
		font-size: 22px;
		font-weight: 700;
		margin-bottom: 12px;
		color: #1a1a1a;
	}

	.newfeature-inner-box h4 a {
		color: inherit;
		text-decoration: none;
	}

	.newfeature-text {
		font-size: 16px;
		line-height: 1.6;
		color: #555;
	}

	/* Responsive */
	@media (max-width: 991px) {
		.newfeature-feature-block {
			flex: 0 0 50%;
			max-width: 50%;
		}
	}

	@media (max-width: 767px) {
		.newfeature-feature-block {
			flex: 0 0 100%;
			max-width: 100%;
		}
	}

	.upcoming-current-affairs {
		transition: all 0.3s ease;
	}

	.upcoming-current-affairs:hover {
		box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
	}

	.upcoming-card {
		transition: all 0.25s ease;
		cursor: pointer;
		box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;
	}

	.upcoming-card:hover {
		transform: translateY(-4px);
		box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
		background-color: #f8f9fa !important;
	}

	.arrow-45deg {
		opacity: 0.7;
		transition: all 0.3s ease;
	}

	.upcoming-card:hover .arrow-45deg {
		opacity: 1;
		transform: scale(1.15);
	}

	.rotate-45 {
		transform: rotate(45deg);
		filter: brightness(0.9) contrast(1.1);
		/* optional – makes it pop */
	}

	/* Make whole card clickable */
	.upcoming-card a.stretched-link::after {
		content: "";
		position: absolute;
		inset: 0;
		z-index: 1;
	}

	.mat-study-materials {
		background: #f8f9fa;
	}

	.mat-main-card {
		max-width: 1400px;
		margin: 0 auto;
		border-radius: 20px !important;
	}

	.mat-sidebar {
		background: #ffffff;
		min-height: 500px;
		/* adjust as needed */
	}

	.mat-category-btn {
		background: #f0f4ff;
		/* light pastel blue */
		border: none;
		border-radius: 12px;
		padding: 12px 20px;
		font-weight: 500;
		color: #2c3e50;
		transition: all 0.25s ease;
		text-align: left;
	}

	.mat-category-btn:hover {
		background: #e3efff;
		transform: translateX(4px);
	}

	.mat-category-btn.active {
		background: #0d6efd;
		color: white;
		font-weight: 600;
	}

	.mat-tabs-wrapper {
		background: #ffffff;
	}

	.mat-tab-btn {
		background: #f1f3f5;
		border: none;
		border-radius: 50px !important;
		padding: 10px 24px;
		font-weight: 500;
		color: #495057;
		transition: all 0.3s;
	}

	.mat-tab-btn.active,
	.mat-tab-btn:hover {
		background: #0d6efd;
		color: white;
	}

	.mat-divider {
		height: 1px;
		background: #e9ecef;
		opacity: 0.6;
		margin: 0;
	}

	.mat-resource-card {
		transition: all 0.3s ease;
		border: 1px solid #e9ecef;
		border-radius: 16px !important;
	}

	.mat-resource-card:hover {
		transform: translateY(-8px);
		box-shadow: 0 12px 32px rgba(13, 110, 253, 0.12) !important;
		border-color: #0d6efd;
	}

	.mat-card-icon {
		width: 70px;
		height: 70px;
		background: rgba(13, 110, 253, 0.08);
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		margin: 0 auto;
	}

	/* Responsive */
	@media (max-width: 991px) {
		.mat-sidebar {
			border-end: none !important;
			border-bottom: 1px solid #e9ecef;
		}

		.mat-main-card .row.g-0 {
			flex-direction: column;
		}
	}

	.mat-main-card {
		max-width: 1400px;
		margin: 0 auto;
		border-radius: 20px !important;
	}

	.mat-sidebar {
		background: #ffffff;
	}

	.mat-category-btn {
		background: #e7efff !important;
		border: none;
		border-radius: 12px;
		font-weight: 500;
		color: #000000 !important;
		transition: all 0.25s;
	}

	.mat-category-btn:hover {
		background: #e3efff;
	}

	.mat-category-btn.active {
		background: #045279 !important;
		color: white !important;
		box-shadow: 0 2px 8px rgba(13, 110, 253, 0.25);
	}

	.mat-tab-btn {
		background: #f1f3f5;
		border: none;
		border-radius: 50px !important;
		padding: 10px 24px;
		color: #495057;
		font-weight: 500;
	}

	.mat-tab-btn.active {
		background: #045279 !important;
		color: white !important;
	}

	.mat-resource-card {
		transition: all 0.3s ease;
		border: 1px solid #e9ecef;
		border-radius: 16px !important;
	}

	.mat-resource-card:hover {
		transform: translateY(-6px);
		box-shadow: 0 10px 30px rgba(13, 110, 253, 0.1) !important;
	}

	.mat-category-btn.active,
	.mat-tab-btn.active {
		background: #045279 !important;
		color: white !important;
	}

	.mat-resource-card:hover {
		transform: translateY(-6px);
		box-shadow: 0 10px 30px rgba(13, 110, 253, 0.12) !important;
	}

	/* Professional Horizontal Scrollbar for .nav-pills */
	.nav-pills {
		display: flex;
		flex-wrap: nowrap !important;
		overflow-x: auto;
		/* Changed from scroll → auto (better UX) */
		padding-left: 0;
		margin-bottom: 0;
		list-style: none;

		/* Hide default scrollbar in most browsers */
		scrollbar-width: thin;
		/* Firefox */
		scrollbar-color: #cbd5e1 #f1f5f9;
		/* Firefox track & thumb */

		-ms-overflow-style: none;
		/* IE and Edge */
	}

	/* Hide scrollbar for Chrome, Safari, Opera */
	.nav-pills::-webkit-scrollbar {
		height: 6px;
		/* Very thin horizontal scrollbar */
	}

	/* Track (background) */
	.nav-pills::-webkit-scrollbar-track {
		background: #f1f5f9;
		/* Light gray — subtle */
		border-radius: 10px;
		margin: 0 4px;
		/* Slight padding from edges */
	}

	/* Thumb (scroll handle) */
	.nav-pills::-webkit-scrollbar-thumb {
		background: #94a3b8;
		/* Slate gray — professional */
		border-radius: 10px;
		border: 2px solid #f1f5f9;
		/* Gives floating effect */
	}

	/* Thumb on hover/active */
	.nav-pills::-webkit-scrollbar-thumb:hover {
		background: #64748b;
		/* Darker on hover */
	}

	/* Optional: Glow / shadow effect on hover */
	.nav-pills::-webkit-scrollbar-thumb:active {
		background: #475569;
		box-shadow: 0 0 8px rgba(100, 116, 139, 0.5);
	}

	/* Smooth scrolling behavior */
	.nav-pills {
		scroll-behavior: smooth;
	}

	/* Optional: Fade edges when scrollable (very premium look) */
	.nav-pills::before,
	.nav-pills::after {
		content: "";
		position: absolute;
		top: 0;
		bottom: 0;
		width: 20px;
		pointer-events: none;
		z-index: 1;
	}

	.nav-pills::before {
		left: 0;
		background: linear-gradient(to right, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0) 100%);
	}

	.nav-pills::after {
		right: 0;
		background: linear-gradient(to left, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0) 100%);
	}

	/* Smooth & Professional Horizontal Scroll for newtab-wrapper */
	.newtab-wrapper {
		position: relative;
		overflow: hidden;
		/* Edges clean rakhe */
		padding: 0 10px;
		/* Thoda breathing space edges pe */
	}

	.newtab-item {
		display: flex;
		flex-wrap: nowrap;
		white-space: nowrap;
	}

	.newtab-menu {
		display: flex;
		flex-wrap: nowrap;
		overflow-x: auto;
		padding-bottom: 12px;
		/* Scrollbar ke liye space niche */
		scroll-behavior: smooth;
		/* Smooth scrolling jab arrow ya swipe kare */
		-webkit-overflow-scrolling: touch;
		/* iOS pe smooth feel */
		scrollbar-width: thin;
		/* Firefox */
		scrollbar-color: #94a3b8 #f1f5f9;
		/* Thumb aur track color */
	}

	/* Chrome, Safari, Edge scrollbar styling */
	.newtab-menu::-webkit-scrollbar {
		height: 6px;
		/* Bahut thin scrollbar */
	}

	.newtab-menu::-webkit-scrollbar-track {
		background: #f1f5f9;
		/* Light background */
		border-radius: 10px;
		margin: 0 8px;
		/* Edges se thoda space */
	}

	.newtab-menu::-webkit-scrollbar-thumb {
		background: #94a3b8;
		/* Slate gray — professional */
		border-radius: 10px;
		border: 2px solid #f1f5f9;
		/* Floating effect deta hai */
	}

	.newtab-menu::-webkit-scrollbar-thumb:hover {
		background: #64748b;
		/* Hover pe dark ho jaye */
	}

	/* Active tab pe glow/under line effect (optional bonus) */
	.newtab-item.active .newtab-link {
		color: #3b82f6 !important;
		font-weight: 600;
		position: relative;
	}

	.newtab-item.active .newtab-link::after {
		content: '';
		position: absolute;
		bottom: -8px;
		left: 0;
		right: 0;
		height: 3px;
		background: #3b82f6;
		border-radius: 3px;
	}

	/* Fade edges jab scrollable ho (premium touch) */
	.newtab-wrapper::before,
	.newtab-wrapper::after {
		content: "";
		position: absolute;
		top: 0;
		bottom: 0;
		width: 30px;
		pointer-events: none;
		z-index: 1;
	}

	.newtab-wrapper::before {
		left: 0;
		background: linear-gradient(to right, #f3f4f6 0%, rgba(243, 244, 246, 0) 100%);
	}

	.newtab-wrapper::after {
		right: 0;
		background: linear-gradient(to left, #f3f4f6 0%, rgba(243, 244, 246, 0) 100%);
	}

	.nav-item {
		white-space: nowrap;
	}

	.nav-pills .btn-outline-secondary.active {
		background-color: #045279;
		color: white;
		border-color: #045279;
	}

	.btn-sm11 {
		padding: 0.5rem .5rem;
		font-size: 26px;
		border-radius: .2rem;
	}

	.boost-card {
		/*transition: all 0.3s ease;*/
		border: 1px solid #e9ecef;
		border-radius: 10px !important;
	}

	.boost-card:hover {
		/*transform: translateY(-8px);*/
		/*box-shadow: 0 15px 40px rgba(0,0,0,0.12) !important;*/
	}

	.boost-thumbnail {
		/*transition: transform 0.4s ease;*/
		object-fit: cover;
		height: 220px;
		/* fixed height for uniformity */
	}

	.boost-card:hover .boost-thumbnail {
		/*transform: scale(1.08);*/
	}

	.btn-play {
		width: 80px;
		height: 80px;
		background: rgba(13, 110, 253, 0.9);
		border: none;
		color: white;
		transition: all 0.3s;
	}

	.btn-play:hover {
		background: rgba(13, 110, 253, 1);
		/*transform: scale(1.1);*/
	}

	.thumbnail-wrapper {
		border-radius: 16px 16px 0 0;
		overflow: hidden;
	}

	.boost-card {
		padding: 5px;
	}


	/* ==============================================
		   Custom prefix: jj- (to avoid overrides)
		   ============================================== */

	.jj-notifications .jj-section-title {
		font-size: 2.8rem !important;
		margin-bottom: 0.5rem !important;
	}

	.jj-notifications .jj-subtitle {
		font-size: 1.35rem !important;
	}

	.jj-exam-card {
		transition: all 0.35s ease !important;
		border-radius: 10px !important;
	}

	.jj-exam-card:hover {
		transform: translateY(-8px) !important;
		box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08) !important;
		border-color: #d0e0ff !important;
	}

	.jj-commission-badge .jj-badge-label {
		background: #e6f0ff2e !important;
		color: #7a7b7c !important;
		font-weight: 600 !important;
		padding: 10px 24px !important;
		border-radius: 8px !important;
		display: inline-block !important;
	}

	.jj-exam-name {
		font-size: 1.5rem !important;
		line-height: 1.3 !important;
		min-height: 60px !important;
		text-align: center !important;
	}

	.jj-details-list .jj-detail-row {
		font-size: 1.05rem !important;
		border-bottom: 1px solid #f0f0f0 !important;
	}

	.jj-details-list .jj-label {
		color: #555 !important;
		flex: 0 0 45% !important;
	}

	.jj-details-list .jj-value {
		flex: 1 !important;
		text-align: right !important;
		color: #222 !important;
	}

	.jj-download-btn {
		background: #f0f7ff !important;
		/* very light blue */
		color: #0d6efd !important;
		border: 2px solid #c3d8ff !important;
		font-size: 1.1rem !important;
		transition: all 0.3s ease !important;
	}

	.jj-download-btn:hover {
		background: #e0efff !important;
		color: #004dc7 !important;
		border-color: #a0c4ff !important;
		transform: scale(1.02) !important;
		box-shadow: 0 6px 16px rgba(13, 110, 253, 0.15) !important;
	}

	.jj-viewall-btn {
		font-size: 1.2rem !important;
		padding: 14px 40px !important;
	}

	/* Responsive fix */
	@media (max-width: 991px) {
		.jj-exam-card {
			margin-bottom: 1.5rem !important;
		}
	}

	.t-box {
		width: 300px !important;
	}

	.newupdate-testimonial-section {
		background: #ffffff;
	}

	.newupdate-testimonial-card {
		transition: all 0.35s ease;
		border-radius: 16px !important;
		min-height: 320px;
		/* consistent height */
	}

	.newupdate-testimonial-card:hover {
		transform: translateY(-8px);
		box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08) !important;
		border-color: #0d6efd50 !important;
	}

	.newupdate-author-photo img {
		border: 4px solid #0d6efd !important;
		box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15) !important;
	}

	.newupdate-divider {
		border-top: 1px solid #dee2e6 !important;
		margin: 1.5rem 0 !important;
	}

	.newupdate-testimonial-content p {
		font-size: 1.15rem !important;
		line-height: 1.8 !important;
		color: #444 !important;
		font-style: italic !important;
	}

	/* Owl Carousel arrows & dots styling (optional polish) */
	.owl-carousel .owl-nav button {
		background: #0d6efd !important;
		color: white !important;
		width: 50px !important;
		height: 50px !important;
		border-radius: 50% !important;
		margin: 0 -20px !important;
		font-size: 1.5rem !important;
	}

	.owl-carousel .owl-dots .owl-dot.active span {
		background: #0d6efd !important;
	}

	/* Mobile */
	@media (max-width: 767px) {
		.newupdate-testimonial-card {
			min-height: auto !important;
		}
	}

	.news-block .lower-content {
		text-align: left;
	}

	.news-block {
		border-radius: 10px;
		overflow: hidden;
		border: 10px solid #fff;
		box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;

	}

	.news-block .lower-content {
		padding: 0px !important;
	}

	.news-block h5 {
		height: 38px;
		font-size: 16px !important;
	}

	.news-block .text {
		height: 50px;
	}

	.news-block .more-post {
		float: inline-end;
	}

	.news-block .lower-content {
		box-shadow: 0px 5px 15px rgba(0, 0, 0, 00) !important;
	}

	.newtestseries-section {
		background: #f8f9fa;
	}

	.newtestseries-main-heading {
		font-size: 2.8rem !important;
	}

	.newtestseries-sub-heading {
		max-width: 800px;
		margin: 0 auto;
	}

	.newtestseries-card {
		transition: all 0.35s ease;
		border-radius: 16px !important;
	}

	.newtestseries-card:hover {
		transform: translateY(-10px);
		box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08) !important;
	}

	.newtestseries-logo-frame {
		width: 100%;
		height: 200px !important;
		padding: 8px;
		background: white;
		/*box-shadow: 0 4px 12px rgba(0,0,0,0.1);*/
	}

	.newtestseries-title {
		font-size: 1.4rem !important;
		min-height: 50px;
	}

	.newtestseries-divider {
		border-top: 2px solid #dee2e6 !important;
	}

	.newtestseries-test-count {
		font-size: 1.1rem !important;
	}

	.newtestseries-free {
		font-weight: 600 !important;
	}

	.newtestseries-features .newtestseries-feature-row {
		font-size: 1.05rem !important;
	}

	.newtestseries-label {
		color: #555 !important;
		flex: 0 0 60% !important;
	}

	.newtestseries-value {
		color: #222 !important;
		font-weight: 600 !important;
		text-align: right !important;
	}

	.newtestseries-view-btn {
		background: linear-gradient(90deg, #0d6efd, #0056b3) !important;
		color: white !important;
		border: none !important;
		font-size: 1.1rem !important;
		transition: all 0.3s !important;
	}

	.newtestseries-view-btn:hover {
		background: linear-gradient(90deg, #0056b3, #004085) !important;
		transform: translateY(-2px) !important;
		box-shadow: 0 8px 20px rgba(13, 110, 253, 0.25) !important;
	}

	.newtestseries-all-btn {
		font-size: 1.2rem !important;
		padding: 14px 40px !important;
	}

	.upcoming-card {
		transition: all 0.25s ease;
	}

	.upcoming-card:hover {
		transform: translateY(-4px);
		box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
	}

	.upcoming-dates .d-flex {
		font-size: 0.95rem;
	}

	.upcoming-dates .fw-medium {
		min-width: 140px;
		color: #444;
	}

	.newprog-section {
		background: #ffffff !important;
	}

	.newprog-image-frame {
		border: 12px solid white !important;
		box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
	}

	.newprog-title {
		font-size: 2.4rem !important;
		line-height: 1.3 !important;
	}

	.newprog-description {
		font-size: 1.15rem !important;
		line-height: 1.8 !important;
	}

	.newprog-icon-card {
		transition: all 0.3s ease !important;
		border: 1px solid #e0e0e0 !important;
	}

	.newprog-icon-card:hover {
		transform: translateY(-6px) !important;
		box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1) !important;
	}

	.newprog-explore-btn {
		background: linear-gradient(90deg, #0d6efd, #0056b3) !important;
		color: white !important;
		border: none !important;
		font-size: 1.15rem !important;
		transition: all 0.3s !important;
	}

	.newprog-explore-btn:hover {
		background: linear-gradient(90deg, #0056b3, #004085) !important;
		transform: translateY(-3px) !important;
		box-shadow: 0 8px 20px rgba(13, 110, 253, 0.25) !important;
	}

	/* Responsive */
	@media (max-width: 991px) {
		.newprog-image-frame {
			margin-bottom: 2rem !important;
		}
	}

	.newprog-image-frame {
		border-radius: 10px;
	}

	.newprog-number-card {
		display: flex;
		gap: 15px;
		align-items: center;
		transition: all 0.35s ease !important;
		box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
	}

	.newprog-number-card:hover {
		transform: translateY(-8px) !important;
		box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
	}

	.newprog-number-circle {
		width: 60px !important;
		height: 60px !important;
		font-size: 1.6rem !important;
		font-weight: bold !important;
		line-height: 1 !important;
	}

	.newprog-explore-btn {
		background: linear-gradient(90deg, #28a745, #1e7e34) !important;
		/* Green gradient */
		color: white !important;
		border: none !important;
		font-size: 1.3rem !important;
		transition: all 0.3s !important;
		box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3) !important;
	}

	.newprog-explore-btn:hover {
		background: linear-gradient(90deg, #218838, #1c6e2c) !important;
		transform: translateY(-3px) !important;
		box-shadow: 0 10px 25px rgba(40, 167, 69, 0.4) !important;
	}

	.newprog-cta-wrapper {
		transition: all 0.35s ease;
		border-radius: 15px;
	}

	.newprog-cta-wrapper:hover {
		transform: translateY(-4px);
		box-shadow: 0 15px 40px rgba(16, 185, 129, 0.3) !important;
	}

	.newprog-cta-pill {
		transition: all 0.3s ease;
		font-size: 1.1rem !important;
	}

	.newprog-cta-pill:hover {
		background: linear-gradient(90deg, #34d399, #10b981) !important;
		transform: scale(1.05);
		box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4) !important;
	}

	/* Responsive – text stacks on mobile */
	@media (max-width: 991px) {
		.newprog-cta-wrapper .d-flex {
			flex-direction: column !important;
			text-align: center !important;
		}

		.newprog-cta-pill {
			width: 100% !important;
		}
	}

	.newupdate-testimonial-card {
		transition: all 0.35s ease;
		border: 1px solid #e9ecef;
		border-radius: 16px !important;
		min-height: 380px;
		/* same height for all cards */
	}

	.newupdate-testimonial-card:hover {
		transform: translateY(-10px);
		box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08) !important;
	}

	.quote-open,
	.quote-close {
		font-size: 6rem !important;
		line-height: 1 !important;
		font-family: Georgia, serif;
	}

	.stars {
		font-size: 1.4rem !important;
		letter-spacing: 3px;
	}

	.t-img img {
		width: 100%;
		height: 230px !important;
		border-radius: 8px;
	}

	.faq-section {
		background: #f4f8f4;
		padding: 70px 0 !important;
		margin-top: 40px !important;
	}

	.faq-container {
		width: 90%;
		max-width: 1200px;
		margin: auto;
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 40px;
	}

	/* LEFT FAQ */
	.faq-title {
		font-size: 32px;
		font-weight: 700;
		color: #333;
		margin-bottom: 25px;
	}

	.faq-box {
		display: flex;
		flex-direction: column;
		gap: 20px;
	}

	.faq-item {
		background: #fff;
		padding: 18px 20px;
		border-radius: 12px;
		box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.08);
		cursor: pointer;
		transition: 0.3s;
	}

	.faq-item:hover {
		transform: translateY(-4px);
	}

	.faq-question {
		font-size: 18px;
		font-weight: 600;
		color: #222;
		margin-bottom: 8px;
	}

	.faq-answer {
		font-size: 15px;
		color: #555;
		line-height: 1.5;
	}

	/* RIGHT FORM */
	.faq-form-card {
		background: #fff;
		padding: 45px 30px;
		border-radius: 14px;
		box-shadow: 0px 3px 15px rgba(0, 0, 0, 0.07);
	}

	.faq-form-title {
		font-size: 28px;
		font-weight: 700;
		color: #333;
		margin-bottom: 8px;
	}

	.faq-form-sub {
		font-size: 15px;
		color: #666;
		margin-bottom: 25px;
	}

	/* FORM FIELDS */
	.faq-input,
	.faq-textarea {
		width: 100%;
		padding: 12px 14px;
		border-radius: 8px;
		border: 1px solid #ccc;
		font-size: 15px;
		margin-bottom: 18px;
		outline: none;
		transition: 0.3s;
	}

	.faq-input:focus,
	.faq-textarea:focus {
		border-color: #045279;
		box-shadow: 0px 0px 5px rgba(255, 136, 0, 0.4);
	}

	/* BUTTON */
	.faq-btn {
		width: 100%;
		background: #045279;
		color: #fff;
		border: none;
		padding: 14px;
		font-size: 16px;
		font-weight: 600;
		border-radius: 8px;
		cursor: pointer;
		transition: 0.3s;
	}

	.faq-btn:hover {
		background: #e07200;
	}

	/* RESPONSIVE */
	@media (max-width: 900px) {
		.faq-container {
			grid-template-columns: 1fr;
		}
	}

	.faq-item {
		background: #fff;
		padding: 18px 20px;
		border-radius: 12px;
		box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.08);
		cursor: pointer;
		transition: 0.3s;
	}

	.faq-question-row {
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.faq-icon {
		font-size: 24px;
		font-weight: 700;
		color: #397839;
		transition: 0.3s;
	}

	/* answer hidden by default */
	.faq-answer {
		font-size: 15px;
		color: #555;
		line-height: 1.5;
		margin-top: 10px;
		display: none;
	}

	/* when active */
	.faq-item.active .faq-answer {
		display: block;
	}

	.faq-item.active .faq-icon {
		transform: rotate(180deg);
		content: "-";
	}

	.faq-phone-group {
		display: flex;
		gap: 10px;
		width: 100%;
	}

	.faq-country {
		width: 120px;
		margin-bottom: 18px;
		padding: 12px;
		border-radius: 8px;
		border: 1px solid #ddd;
		font-size: 15px;
		background: #fff;
		cursor: pointer;
	}

	.phone-input {
		flex: 1;
	}
</style>

@section('content')

	<body class="hidden-bar-wrapper">

		@php
			$pageContent = App\Models\PageContent::pluck('heading', 'section_key');
			$pageSubContent = App\Models\PageContent::pluck('sub_heading', 'section_key');
		@endphp
		<!-- Page Load Modal Start -->
		@if(isset($popup) && isset($popup->pop_image))
			<div class='popup-onload'>
				<div class='cnt223'>
					<img src="{{ asset('storage/' . $popup->pop_image) }}" />
					<i class="fa fa-close close"></i>
				</div>
			</div>
		@endif
		<!-- Page Load Modal End -->

		<!-- Main Slider Section Start -->
		<section class="home-section ">
			<div class="container">
				<div class="row align-items-stretch">

					<!-- Banner Slider Box -->
					<div class="col-md-8" style="padding-right:0px;">
						<div class="card box-shadow h-100 p-0">
							<div class="main-slider-carousel owl-carousel owl-theme">

								@foreach($sliders as $data)
									<div class="slide">
										<a href="{{ $data->url ?? '#' }}" target="_blank">
											<img src="{{ asset('storage/' . $data->image) }}" class="banner-img" />
										</a>
									</div>
								@endforeach

							</div>
						</div>
					</div>

					<!-- Notice Board Box -->
					<div class="col-md-4">
						<div class="card notice-box shadow rounded-card">

							<!-- Header -->
							<div class="card-header notice-header">
								<span class="nb-icon">📢</span>
								<h5 class="mb-0 fw-bold">Notice Board</h5>
							</div>

							<!-- Notice Section -->
							<div class="notice-scroll" id="noticeArea">

								@foreach($notices as $notice)
									<div class="notice-item">
										📌 {{ $notice->title }}

										@if($notice->type == 'pdf' && $notice->file)
											<a href="{{ asset('storage/' . $notice->file) }}" target="_blank"
												class="arrow-link">➜</a>

										@elseif($notice->type == 'link' && $notice->url)
											<a href="{{ $notice->url }}" target="_blank" class="arrow-link">➜</a>

										@elseif($notice->type == 'page')
											<a href="{{ route('notice.show', $notice->id) }}" class="arrow-link">➜</a>
										@endif

									</div>
								@endforeach
							</div>
							<!-- Footer Controls -->
							<div class="card-footer notice-footer">
								<button id="scrollUp" class="scroll-btn">▲</button>
								<button id="scrollDown" class="scroll-btn">▼</button>
							</div>

						</div>
					</div>

				</div>
			</div>
		</section>
		<!-- Main Slider Section End -->

		<!-- Start Current News Section  -->
		<div class="bottom-header">
			<div class="container">
				<div class="maq-container">
					<div class="latest-head">
						<span>LATEST NEWS :</span>
					</div>
					<div class="marq-info">
						<marquee class="mar" width="90%" direction="left" onmouseover="this.stop();"
							onmouseout="this.start();">
							@foreach($current_news as $key => $data)
								@if($data->type == 'pdf' && $data->file)
									<a style="text-decoration:none;color:white;" href="{{ asset('storage/' . $data->file) }}"
										target="_blank">{{$data->title}},</a>

								@elseif($data->type == 'link' && $data->url)
									<a style="text-decoration:none;color:white;" href="{{ $data->url }}"
										target="_blank">{{$data->title}},</a>

								@elseif($data->type == 'page')
									<a style="text-decoration:none;color:white;"
										href="{{ route('news.show', $data->id) }}">{{$data->title}},</a>
								@endif

							@endforeach
						</marquee>
					</div>
				</div>
			</div>
		</div>
		<!-- End Current News Section  -->

		<!-- Start Intro Section  -->
		<section class="intro-section">

			<h2 class="main-heading">{{ $pageContent['intro'] ?? 'Welcome to ADHYAYANAM E-LEARNING' }}</h2>
			<p class="sub-heading">
				{{ $pageSubContent['intro'] ?? "Get unlimited access to the most relevant Mock Tests, on India's Structured Online Test series platform"}}
			</p>

			<div class="intro-container">

				@php
					$intro = App\Models\HomeIntroduction::with('highlights')->first();
				@endphp
				<!-- LEFT COL (4) -->
				<div class="intro-left-card">
					@if(isset($intro->image))
						<img src="{{ asset('storage/' . $intro->image) }}" alt="Intro Image">
					@endif
				</div>

				<!-- RIGHT COL (8) -->
				<div class="intro-right-card">

					<!-- INNER LEFT (CONTENT) -->
					<div class="right-content">
						<h3>{{ $intro->heading }}</h3>

						<p class="text">{!!  $intro->description !!}</p>

						<div class="cta-btn-group1">
							<a href="#" class="cta-btn1 buyer">Get Started</a>
							<a href="#" class="cta-btn1 seller">Join Now</a>
						</div>

					</div>

					<!-- INNER RIGHT (BULLET POINTS) -->
					<div class="right-points">
						<ul class="bullet-points">
							@if(isset($intro->highlights))
								@foreach($intro->highlights as $point)
									<li class="point-card">
										{{ $point->text }}
									</li>
								@endforeach
							@endif
						</ul>
					</div>
				</div>
			</div>
		</section>
		<!-- End Intro Section  -->

		<!-- Start Courses Section  -->
		<!--<section class="course-page-section osd">-->
		<!--	<div class="container" style="padding:30px;">-->

		<!--		<div class="row clearfix">-->
		<!--			<div class="col-12">-->
		<!--				<div class="sec-title centered">-->
		<!--					<h2 class="main-heading">{{ $pageContent['courses'] ?? 'Courses We Offers' }}</h2>-->
		<!--					<p class="sub-heading">-->
		<!--						{{ $pageSubContent['courses'] ?? "Get unlimited access to the most relevant Mock Tests, on India's Structured Online Test series platform"}}-->

		<!--					</p>-->
		<!--				</div>-->
		<!--			</div>-->

		<!--			<div class="newtab-wrapper">-->
		<!--				<ul class="newtab-menu">-->
		<!--					<li class="newtab-item active" data-tab="all">All Courses</li>-->
		<!--					@foreach($commissions as $commission)-->
		<!--						<li class="newtab-item" data-tab="{{ strtolower($commission->slug ?? $commission->id) }}">-->
		<!--							{{ $commission->name }}-->
		<!--						</li>-->
		<!--					@endforeach-->

		<!--				</ul>-->
		<!--			</div>-->
		<!--			@foreach($courses as $course)-->
		<!--				<div class="edu-course-card col-xl-3 col-lg-6 col-md-6 sm-12"-->
		<!--					data-commission="{{ strtolower($course->examinationCommission->slug ?? $course->examinationCommission->id) }}">-->
		<!--					<div class="edu-card">-->
		<!--						<div class="edu-card-image">-->
		<!--							<a href="{{ route('courses.detail', $course->id) }}" class="block">-->
		<!--								<img src="{{ url('storage/' . $course->thumbnail_image) }}"-->
		<!--									alt="{{ $course->image_alt_tag }}" class="edu-thumbnail">-->
		<!--							</a>-->
		<!--						</div>-->

		<!--						<div class="edu-card-body">-->
		<!--							<div class="edu-meta">-->
		<!--								<div class="edu-duration">-->
		<!--									<span class="icon flaticon-hourglass"></span>-->
		<!--									{{ $course->duration }} Week-->
		<!--								</div>-->

		<!--								<div class="edu-price">₹{{ $course->offered_price }}</div>-->
		<!--							</div>-->
		<!--							<p class="commission-name">{{$course->examinationCommission->name}}</p>-->

		<!--							<h3 class="edu-title">-->
		<!--								<a href="{{ route('courses.detail', $course->id) }}">{{ $course->name }}</a>-->
		<!--							</h3>-->

		<!--							<p class="edu-description">{{ $course->course_heading }}</p>-->

		<!--							<div class="edu-actions">-->

		<!--								<a href="{{ route('courses.detail', $course->id) }}" class="edu-btn edu-btn-outline"-->
		<!--									style="width: 100%;-->
		<!--																																																																																																											display: flex;-->
		<!--																																																																																																											justify-content: center;-->
		<!--																																																																																																											text-align: center;-->
		<!--																																																																																																										">-->
		<!--									View Details-->
		<!--									<span class="arrow-icon flaticon-arrow-pointing-to-right"></span>-->
		<!--								</a>-->
		<!--							</div>-->
		<!--						</div>-->
		<!--					</div>-->
		<!--				</div>-->
		<!--			@endforeach-->
		<!--			<div class="col-12">-->
		<!--				<div class="button-box">-->
		<!--					<a href="{{route('courses')}}" class="theme-btn btn-style-three"><span class="txt">View-->
		<!--							All</span></a>-->
		<!--				</div>-->
		<!--			</div>-->

		<!--		</div>-->
		<!--	</div>-->
		<!--</section>-->
		<section class="course-page-section osd py-5 bg-white">
			<div class="container" style="padding:30px;">
				<div class="sec-title text-center mb-5">
					<h2 class="main-heading">{{ $pageContent['courses'] ?? 'Courses We Offers' }}</h2>
					<p class="sub-heading">
						{{ $pageSubContent['courses'] ?? "Get unlimited access to the most relevant Mock Tests, on India's Structured Online Test series platform" }}
					</p>
				</div>
				<div class="mat-main-card shadow-lg rounded-4 overflow-hidden border border-light bg-white">
					<div class="row g-0">
						<!-- LEFT SIDEBAR: Commissions -->
						<div class="col-lg-3 mat-sidebar border-end bg-white shadow-sm rounded-start">
							<div class="p-4">
								<h5 class="fw-bold mb-4 text-start text-black">Examination Commission</h5>
								<hr>
								<div class="nav flex-column nav-pills gap-2" id="commissionTabsCourses" role="tablist"
									aria-orientation="vertical">
									@foreach($commissions as $index => $commission)
										<button
											class="mat-category-btn nav-link w-100 text-start py-3 px-4 {{ $index == 0 ? 'active' : '' }}"
											data-bs-toggle="pill" data-bs-target="#commission-courses-{{ $commission->id }}"
											type="button" data-commission-id="{{ $commission->id }}">
											{{ $commission->name }}
										</button>
									@endforeach
								</div>
							</div>
						</div>

						<!-- RIGHT CONTENT -->
						<div class="col-lg-9">
							<div class="p-4 bg-white ">
								<!-- Sub-Category Tabs -->
								<ul class="nav nav-pills mb-4 gap-3 flex-nowrap overflow-auto" id="subCategoryTabsCourses">
									<!-- "All" tab by default -->
									<li class="nav-item">
										<button class="btn btn-outline-secondary btn-sm11 active" data-category="all">
											All Courses
										</button>
									</li>
									<!-- Sub-categories will be dynamically added here via JS -->
								</ul>

								<!-- All Courses Cards (filtered by JS) -->
								<div class="row g-4 courses-grid">
									@foreach($courses as $course)
										<div class="edu-course-card col-xl-4 col-lg-6 col-md-6 col-sm-12"
											data-commission="{{ strtolower($course->examinationCommission->slug ?? $course->examinationCommission->id) }}"
											data-category="{{ $course->category_id ?? 'all' }}"
											data-category-name="{{ addslashes($course->category->name ?? 'Unknown') }}">
											<div class="edu-card">
												<div class="edu-card-image">
													<a href="{{ route('courses.detail', $course->id) }}" class="block">
														<img src="{{ url('storage/' . $course->thumbnail_image) }}"
															alt="{{ $course->image_alt_tag }}" class="edu-thumbnail">
													</a>
												</div>
												<div class="edu-card-body">
													<div class="edu-meta">
														<div class="edu-duration">
															<span class="icon flaticon-hourglass"></span>
															{{ $course->duration }} Week
														</div>
														<div class="edu-price">₹{{ $course->offered_price }}</div>
													</div>
													<p class="commission-name">{{ $course->examinationCommission->name }}</p>
													<h3 class="edu-title">
														<a
															href="{{ route('courses.detail', $course->id) }}">{{ $course->name }}</a>
													</h3>
													<p class="edu-description">{{ $course->course_heading }}</p>
													<div class="edu-actions">
														<a href="{{ route('courses.detail', $course->id) }}"
															class="edu-btn edu-btn-outline"
															style="width: 100%; display: flex; justify-content: center; text-align: center;">
															View Details
															<span class="arrow-icon flaticon-arrow-pointing-to-right"></span>
														</a>
													</div>
												</div>
											</div>
										</div>
									@endforeach
								</div>

								<!-- View All Button -->
								<div class="text-center mt-5">
									<a href="{{ route('courses') }}"
										class="newtestseries-all-btn btn btn-outline-primary btn-lg px-5 py-3 rounded-pill">
										View All Courses
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Courses Section  -->

		<!-- Start Intstitute Feature Section  -->
		<section class="newfeature-featured-section">
			<div class="newfeature-auto-container">

				<h2 class="main-heading">{{ $pageContent['features'] ?? 'ADHYAYANAM – Your Path to Success' }}</h2>

				<p class="sub-heading text-center">
					{{ $pageSubContent['features'] ?? "Unlimited Access to High-Quality Mock Tests Designed for UPSC, SSC, Banking, Railways, State PCS & All Major Exams"}}
				</p>

				<div class="newfeature-inner-container">
					<div class="newfeature-row clearfix">

						@foreach($features as $index => $feature)
							<div class="newfeature-feature-block col-lg-3 col-md-6 col-sm-12">
								<div class="newfeature-inner-box wow fadeInUp" data-wow-delay="{{ $index * 100 }}ms"
									data-wow-duration="1500ms">

									<div class="newfeature-icon">
										@if($feature->image)
											<img style="max-width:70px;" src="{{ asset('storage/' . $feature->image) }}"
												alt="{{ $feature->title }}">
										@endif
									</div>

									<h4><a href="#">{{ $feature->title }}</a></h4>

									<div class="newfeature-text">
										{!! $feature->short_description !!}
									</div>

								</div>
							</div>
						@endforeach

					</div>
				</div>

			</div>
		</section>
		<!-- End Intstitute Feature Section  -->

		<!-- Start Current Affairs Section  -->
		<section class="current-aff-osd">
			<div class="container">
				<!-- Current Affairs Block -->
				<div class="row" style="margin:auto;">
					<div class="col-12">
						<h2 class="main-heading">{{ $pageContent['current_affairs'] ?? 'Current Affairs' }}</h2>
						<p class="sub-heading">
							{{ $pageSubContent['current_affairs'] ?? "Get unlimited access to the most relevant Mock Tests, on India's Structured Online Test series platform"}}
						</p>
					</div>

					<div class="row">
						<!-- Left side: 8 columns - Topics with data -->
						<div class="col-md-8">
							<div class="row g-4">
								@foreach($topics as $topic)
									@if($topic->currentAffair && $topic->currentAffair->isNotEmpty())
										<div class="col-md-12">
											<div class="topic-card rounded-3 bg-white overflow-hidden"
												style="max-height: 500px; display: flex; flex-direction: column;">
												<div class="topic-header d-flex align-items-center justify-content-between p-3  text-white"
													style="background:#045279;">
													<h4 class="mb-0 fw-bold fs-5">{{ $topic->name }}</h4>
													<span class="arrow-icon fs-4">↓</span>
												</div>

												<div class="topic-content p-3 flex-grow-1"
													style="overflow-y: auto; max-height: calc(500px - 70px);">
													<!-- header height approx subtract -->
													<div class="d-flex flex-column gap-3">
														@foreach($topic->currentAffair as $affair)
															<a href="{{ route('current.details', $affair->id) }}"
																class="affair-btn text-decoration-none text-dark rounded-3 p-3 shadow-sm hover-shadow bg-pastel-blue">
																<div class="d-flex justify-content-between align-items-center">
																	<div>
																		<strong class="d-block mb-1">{{ $affair->title }}</strong>
																		<small
																			class="text-muted">{{ $affair->short_description }}</small>
																	</div>
																	<span class="arrow-right fs-5 text-primary">→</span>
																</div>
															</a>
														@endforeach
													</div>
												</div>
											</div>
										</div>
									@endif
								@endforeach
							</div>
						</div>

						<!-- Right side: 4 columns - Placeholder (same) -->
						<div class="col-md-4">
							<div
								class="upcoming-current-affairs shadow rounded-3 bg-white h-100 overflow-hidden border border-light">

								<!-- Header -->
								<div class=" text-white p-3 text-center fw-bold fs-5" style="background:#045279;">
									Upcoming Exam
								</div>

								<!-- Card List -->
								<!-- Card List -->
								<div class="p-3 d-flex flex-column gap-3">
									@foreach($upcomingExams as $data) <!-- assuming you have $upcomingExams collection -->
										<div
											class="upcoming-card position-relative bg-light-subtle rounded-3 p-3 hover-lift border-start border-4 border-primary">
											<a href="{{ asset('storage/' . $data->pdf) }}" target="_blank"
												class="stretched-link text-decoration-none d-block h-100">

												<!-- Title (2 lines max) -->
												<h5 class="fw-bold mb-2 text-dark lh-base"
													style="line-height: 1.3; max-height: 3em; overflow: hidden;">
													{{ Str::limit($data->examination_name, 60, '...') }}
												</h5>

												<!-- Short Description -->
												<p class="mb-3 small text-muted lh-sm"
													style="max-height: 3em; overflow: hidden;">
													{{ Str::limit($data->description ?? 'Important government exam notification with complete details.', 100, '...') }}
												</p>

												<!-- Dates – neatly aligned -->
												<div class="upcoming-dates small text-muted mb-3">
													<div
														class="d-flex justify-content-between py-1 border-bottom border-1 border-light">
														<span class="fw-medium">Advertisement Date:</span>
														<span>{{ $data->advertisement_date ?? 'N/A' }}</span>
													</div>
													<div
														class="d-flex justify-content-between py-1 border-bottom border-1 border-light">
														<span class="fw-medium">Exam Date:</span>
														<span>{{ $data->examination_date ?? 'TBA' }}</span>
													</div>
													<div
														class="d-flex justify-content-between py-1 border-bottom border-1 border-light">
														<span class="fw-medium">Last Date to Apply:</span>
														<span
															class="text-danger fw-semibold">{{ $data->submission_last_date ?? 'N/A' }}</span>
													</div>
													@if($data->form_distribution_date)
														<div class="d-flex justify-content-between py-1">
															<span class="fw-medium">Form Available From:</span>
															<span>{{ $data->form_distribution_date }}</span>
														</div>
													@endif
												</div>


											</a>
										</div>
									@endforeach
								</div>

								<!-- Footer hint (optional) -->
								<div class="text-center py-3 border-top small text-muted">
									More upcoming exams & notifications added regularly...
								</div>


							</div>
						</div>
					</div>
					<div class="col-12">
						<div class="button-box">
							<a href="{{route('current.index')}}" class="theme-btn btn-style-three"><span class="txt">View
									All</span></a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Current Affairs Section  -->

		<!-- Start Test Series Section -->
		<!--<section class="newtestseries-section py-5 bg-light">-->
		<!--	<div class="container">-->
		<!-- Section Title -->
		<!--		<div class="sec-title text-center mb-5">-->
		<!--			<h2 class="main-heading">{{ $pageContent['test_series'] ?? 'Our Test Series' }}</h2>-->
		<!--			<p class="sub-heading text-center">-->
		<!--				{{ $pageSubContent['test_series'] ?? "Unlimited Access to High-Quality Mock Tests Designed for UPSC, SSC, Banking, Railways, State PCS& All Major Exams"}}-->
		<!--			</p>-->

		<!--		</div>-->
		<!--		<div class="newtab-wrapper">-->
		<!--			<ul class="newtab-menu">-->

		<!--				<li class="newtab-item active" data-tab="all">All Test Series</li>-->

		<!--				@foreach($commissions as $commission)-->
		<!--					<li class="newtab-item" data-tab="{{ strtolower($commission->slug ?? $commission->id) }}">-->
		<!--						{{ $commission->name }}-->
		<!--					</li>-->
		<!--				@endforeach-->

		<!--			</ul>-->
		<!--		</div>-->
		<!-- Cards Grid -->
		<!--		<div class="row g-4">-->
		<!--			@foreach($testSeries as $data)-->
		<!--				<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 testseries-card"-->
		<!--					data-commission="{{ strtolower($data->commission->slug ?? $data->commission->id) }}">-->

		<!--					<div class="newtestseries-card rounded-4 shadow-sm h-100 overflow-hidden position-relative"-->
		<!--						style="background: linear-gradient(135deg, {{ $loop->index % 3 == 0 ? '#e6f0ff' : ($loop->index % 3 == 1 ? '#eaffea' : '#f3e6ff') }}, #ffffff); border: 1px solid #e0e0e0;">-->
		<!--						<div class="newtestseries-card-inner p-3 d-flex flex-column h-100">-->

		<!-- Logo with white frame -->
		<!--							<div class="newtestseries-logo-wrapper text-center mb-2">-->
		<!--								<div class="newtestseries-logo-frame   border-5 border-white  mx-auto">-->
		<!--									<img src="{{ url('storage/' . $data->logo) }}" alt="{{ $data->title }}" class=""-->
		<!--										style="width: 100%; height: 100%; object-fit: cover;" />-->
		<!--								</div>-->
		<!--							</div>-->

		<!-- Test Series Name -->
		<!--							<h4 class="newtestseries-title fw-bold text-start mb-1 text-dark">-->
		<!--								{{ $data->title }}-->
		<!--							</h4>-->

		<!-- Divider -->
		<!--<hr class="newtestseries-divider mx-auto my-3" style="width: 60%; border-top: 2px solid #dee2e6;">-->

		<!-- Test Count Line -->
		<!--							<div-->
		<!--								class="newtestseries-test-count d-flex justify-content-between align-items-center mb-2 ">-->
		<!--								<span class="newtestseries-count-left fw-medium text-primary">-->
		<!--									{{ count($data->testseries)}} Test-->
		<!--									<span class="newtestseries-free text-success ms-1">| @if($data->fee_type == 'paid')-->
		<!--									Premium @else Free @endif-->
		<!--										Free</span>-->
		<!--								</span>-->
		<!--								<span class="newtestseries-count-right small text-muted">-->
		<!--									Available Now-->
		<!--								</span>-->
		<!--							</div>-->

		<!-- Table-like Features -->
		<!--							<div class="newtestseries-features mb-4 flex-grow-1">-->
		<!--								<div-->
		<!--									class="newtestseries-feature-row d-flex justify-content-between py-2 border-bottom">-->
		<!--									<span class="newtestseries-label">Chapter Test</span>-->
		<!--									<span class="newtestseries-value fw-medium">{{$data->testseries->where('type_name', 'Chapter Test')->count()}}</span>-->
		<!--								</div>-->
		<!--								<div-->
		<!--									class="newtestseries-feature-row d-flex justify-content-between py-2 border-bottom">-->
		<!--									<span class="newtestseries-label">Current Affairs</span>-->
		<!--									<span class="newtestseries-value fw-medium">{{$data->testseries->where('type_name', 'Current Affairs')->count()}}</span>-->
		<!--								</div>-->
		<!--								<div class="newtestseries-feature-row d-flex justify-content-between py-2">-->
		<!--									<span class="newtestseries-label">Subject Test</span>-->
		<!--									<span class="newtestseries-value fw-medium">{{$data->testseries->where('type_name', 'Subject Wise')->count()}}</span>-->
		<!--								</div>-->
		<!--							</div>-->

		<!-- View Button -->
		<!--							<div class="mt-auto">-->
		<!--								<a href=""-->
		<!--									class="newtestseries-view-btn btn  w-100 py-2 fw-medium d-flex align-items-center justify-content-center gap-2">-->
		<!--									<i class="bi bi-arrow-right-circle"></i>-->
		<!--									View Test Series-->
		<!--								</a>-->
		<!--							</div>-->
		<!--						</div>-->
		<!--					</div>-->
		<!--				</div>-->
		<!--			@endforeach-->
		<!--		</div>-->

		<!-- View All Button -->
		<!--		<div class="text-center mt-5">-->
		<!--			<a href="{{ route('test-series-list') }}"-->
		<!--				class="newtestseries-all-btn btn btn-outline-primary btn-lg px-5 py-3 rounded-pill">-->
		<!--				View All Test Series-->
		<!--			</a>-->
		<!--		</div>-->
		<!--	</div>-->
		<!--</section>-->
		<!-- End Test Series Section -->


		<section class="newtestseries-section py-5 bg-light">
			<div class="container">
				<!-- Section Title -->
				<div class="sec-title text-center mb-5">
					<h2 class="main-heading">{{ $pageContent['test_series'] ?? 'Our Test Series' }}</h2>
					<p class="sub-heading text-center">
						{{ $pageSubContent['test_series'] ?? "Unlimited Access to High-Quality Mock Tests Designed for UPSC, SSC, Banking, Railways, State PCS & All Major Exams" }}
					</p>
				</div>
				<div class="mat-main-card shadow-lg rounded-4 overflow-hidden border border-light bg-white">
					<div class="row g-0">
						<!-- LEFT SIDEBAR: Commissions -->
						<div class="col-lg-3 mat-sidebar border-end bg-white shadow-sm rounded-start">
							<div class="p-4">
								<h5 class="fw-bold mb-4 text-start text-black">Examination Commission</h5>
								<hr>
								<div class="nav flex-column nav-pills gap-2" id="commissionTabs" role="tablist"
									aria-orientation="vertical">
									@foreach($commissions as $index => $commission)
										<button
											class="mat-category-btn nav-link w-100 text-start py-3 px-4 {{ $index == 0 ? 'active' : '' }}"
											data-bs-toggle="pill" data-bs-target="#commission-{{ $commission->id }}"
											type="button" data-commission-id="{{ $commission->id }}">
											{{ $commission->name }}
										</button>
									@endforeach
								</div>
							</div>
						</div>

						<!-- RIGHT CONTENT -->
						<div class="col-lg-9">
							<!-- Sub-Category Tabs (dynamically updated) -->
							<div class="p-4 bg-white shadow-sm rounded-end">
								<ul class="nav nav-pills mb-4 gap-3 flex-nowrap overflow-auto" id="subCategoryTabs">
									<!-- "All" tab by default -->
									<li class="nav-item">
										<button class="btn btn-outline-secondary btn-sm11 active" data-category="all">
											All
										</button>
									</li>
									<!-- Sub-categories will be injected here via JS -->
								</ul>

								<!-- Cards Grid -->
								<div class="row g-4 testseries-grid">
									@foreach($testSeries as $data)
										<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 testseries-card"
											data-commission="{{ strtolower($data->commission->slug ?? $data->commission->id) }}"
											data-category="{{ $data->category_id ?? 'all' }}">
											<!-- SAME CARD DESIGN AS ORIGINAL -->
											<div class="newtestseries-card rounded-4 shadow-sm h-100 overflow-hidden position-relative"
												style="background: linear-gradient(135deg, {{ $loop->index % 3 == 0 ? '#e6f0ff' : ($loop->index % 3 == 1 ? '#eaffea' : '#f3e6ff') }}, #ffffff); border: 1px solid #e0e0e0;">
												<div class="newtestseries-card-inner p-3 d-flex flex-column h-100">
													<!-- Logo -->
													<div class="newtestseries-logo-wrapper text-center mb-2">
														<div class="newtestseries-logo-frame border-5 border-white mx-auto">
															<img src="{{ url('storage/' . $data->logo) }}"
																alt="{{ $data->title }}" class="w-100 h-100 object-cover">
														</div>
													</div>
													<!-- Title -->
													<h4 class="newtestseries-title fw-bold text-start mb-1 text-dark">
														{{ $data->title }}
													</h4>
													<!-- Test Count -->
													<div
														class="newtestseries-test-count d-flex justify-content-between align-items-center mb-2">
														<span class="newtestseries-count-left fw-medium text-primary">
															{{ count($data->testseries) }} Test
															<span class="newtestseries-free text-success ms-1">
																| {{ $data->fee_type == 'paid' ? 'Premium' : 'Free' }}
															</span>
														</span>
														<span class="newtestseries-count-right small text-muted">Available
															Now</span>
													</div>
													<!-- Features Table -->
													<div class="newtestseries-features mb-4 flex-grow-1">
														<div
															class="newtestseries-feature-row d-flex justify-content-between py-2 border-bottom">
															<span class="newtestseries-label">Chapter Test</span>
															<span class="newtestseries-value fw-medium">
																{{ $data->testseries->where('type_name', 'Chapter Test')->count() }}
															</span>
														</div>
														<div
															class="newtestseries-feature-row d-flex justify-content-between py-2 border-bottom">
															<span class="newtestseries-label">Current Affairs</span>
															<span class="newtestseries-value fw-medium">
																{{ $data->testseries->where('type_name', 'Current Affairs')->count() }}
															</span>
														</div>
														<div
															class="newtestseries-feature-row d-flex justify-content-between py-2">
															<span class="newtestseries-label">Subject Test</span>
															<span class="newtestseries-value fw-medium">
																{{ $data->testseries->where('type_name', 'Subject Wise')->count() }}
															</span>
														</div>
													</div>
													<!-- View Button -->
													<div class="mt-auto">
														<a href="{{ route('test-series-detail' ,$data->slug) }}"
															class="newtestseries-view-btn btn w-100 py-2 fw-medium d-flex align-items-center justify-content-center gap-2">
															<i class="bi bi-arrow-right-circle"></i>
															View Test Series
														</a>
													</div>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- View All Button -->
				<div class="text-center mt-5">
					<a href="{{ route('test-series-list') }}"
						class="newtestseries-all-btn btn btn-outline-primary btn-lg px-5 py-3 rounded-pill">
						View All Test Series
					</a>
				</div>
			</div>
		</section>
		<!-- Start Study Materials  -->
		<section class="mat-study-materials py-5 bg-white">
			<div class="container" style="padding:30px;">
				<div class="text-center mb-5">
					<h2 class="main-heading">{{ $pageContent['study_material'] ?? 'Our Study Materials' }}</h2>
					<p class="sub-heading">
						{{ $pageSubContent['study_material'] ?? "Get unlimited access to the most relevant Mock Tests, on India's Structured Online Test series platform"}}

					</p>
				</div>

				<div class="mat-main-card shadow-lg rounded-4 overflow-hidden border border-light bg-white">
					<div class="row g-0">

						<!-- LEFT SIDEBAR: Main Categories -->
						<div class="col-lg-3 mat-sidebar border-end">
							<div class="p-4">
								<h5 class="fw-bold mb-4 text-start text-black">Examination Commission</h5>
								<hr>
								<div div class="nav flex-column nav-pills gap-2" id="matMainPills" role="tablist"
									aria-orientation="vertical">
									@foreach($commissions as $index => $commission)
										<button
											class="mat-category-btn nav-link w-100 text-start py-3 px-4 {{ $index == 0 ? 'active' : '' }}"
											data-bs-toggle="pill" data-bs-target="#commission-{{ $commission->id }}"
											type="button">

											{{ $commission->name }}

										</button>
									@endforeach
								</div>
							</div>
						</div>

						<!-- RIGHT CONTENT -->
						<div class="col-lg-9">
							<div class="tab-content p-4" id="matMainTabContent">

								@foreach($commissions as $cIndex => $commission)
									<div class="tab-pane fade {{ $cIndex == 0 ? 'show active' : '' }}"
										id="commission-{{ $commission->id }}">

										<!-- CATEGORY TABS -->
										<ul class="nav nav-pills mb-4 gap-2">
											@foreach($commission->categories as $index => $category)
												<li class="nav-item">
													<button
														class="btn btn-outline-secondary btn-sm11 {{ $index == 0 ? 'active' : '' }}"
														data-bs-toggle="pill"
														data-bs-target="#cat-{{ $commission->id }}-{{ $category->id }}">
														{{ $category->name }}
													</button>
												</li>
											@endforeach
										</ul>

										<hr>

										<!-- CATEGORY CONTENT -->
										<div class="tab-content">

											@foreach($commission->categories as $index => $category)
												<div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
													id="cat-{{ $commission->id }}-{{ $category->id }}">

													<div class="row g-4">

														@foreach($studyMaterial[$commission->id] ?? [] as $material)

															@if($material->category_id == $category->id)

																<div class="edu-course-card col-xl-4 col-lg-6 col-md-6 sm-12"
																	data-commission="{{ $commission->id }}"
																	data-category="{{ $material->category_id ?? 'all' }}"
																	data-category-name="{{ addslashes($category->name) }}">

																	<div class="edu-card">
																		<div class="edu-card-image">
																			<a href="{{ route('study.material.details', $material->id) }}"
																				class="block">
																				<img src="{{ url('storage/' . $material->banner) }}"
																					alt="{{ $material->title }}" class="edu-thumbnail">
																			</a>
																		</div>

																		<div class="edu-card-body">
																			<div class="edu-meta">
																				<div class="edu-duration">
																					{{ $material->is_pdf_downloadable ? 'Pdf Available' : ''}}
																				</div>

																				<div class="edu-price">
																					{{ $material->IsPaid ? '₹' . $material->price : 'Free' }}
																				</div>
																			</div>
																			<p class="commission-name">
																				{{$material->subcategory->name}}
																			</p>

																			<h3 class="edu-title">
																				<a
																					href="{{ route('study.material.details', $material->id) }}">{{ $material->title }}</a>
																			</h3>

																			<p class="edu-description">{{ $material->short_description }}
																			</p>

																			<div class="edu-actions">

																				<a href="{{ route('study.material.details', $material->id) }}"
																					class="edu-btn edu-btn-outline"
																					style="width: 100%;display: flex;justify-content: center; text-align: center;">
																					View Details
																					<span
																						class="arrow-icon flaticon-arrow-pointing-to-right"></span>
																				</a>
																			</div>
																		</div>
																	</div>
																</div>

															@endif

														@endforeach

													</div>
												</div>
											@endforeach

										</div>
									</div>
								@endforeach

							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Study Materials  -->

		<!-- Start Daily Booster Section -->
		<section class="courses-section py-5 " style="background:#f8fbff;">
			<div class="container" style="padding:30px;">
				<!-- Sec Title -->
				<h2 class="main-heading">{{ $pageContent['daily_booster'] ?? 'Daily Booster Videos' }}</h2>
				<p class="sub-heading text-center">
					{{ $pageSubContent['daily_booster'] ?? "Trending Current Affairs Updates"}}
				</p>

				<!-- Modal (only once, outside loop) -->
				<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg modal-dialog-centered">
						<div class="modal-content bg-dark border-0 rounded-4 overflow-hidden">
							<div class="modal-header border-0 pb-0">
								<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
									aria-label="Close"></button>
							</div>
							<div class="modal-body p-0">
								<div class="ratio ratio-16x9">
									<iframe id="videoIframe" src="" title="Daily Boost Video" frameborder="0"
										allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
										allowfullscreen>
									</iframe>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Cards Grid -->
				<div class="row g-4">
					@foreach($dailyBoosts->random(8) as $data)
						<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
							<div class="daily-boost-card h-100">
								<div
									class="boost-card position-relative overflow-hidden rounded-4 shadow-lg bg-white h-100 d-flex flex-column">

									<!-- Thumbnail with white border -->
									<div class="thumbnail-wrapper position-relative overflow-hidden">
										<img src="{{ url('storage/' . $data->thumbnail) }}"
											alt="{{ $data->title ?? 'Daily Boost Video' }}"
											class="w-100 boost-thumbnail rounded-top-4"
											style="border: 6px solid white; border-bottom: none;">
										<!-- Play overlay -->
										<div class="play-overlay position-absolute top-50 start-50 translate-middle">
											<button type="button" class="btn btn-play rounded-circle shadow-lg p-0"
												data-bs-toggle="modal" data-bs-target="#videoModal"
												data-video-url="{{ $data->youtube_url }}">
												<svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="#ffffff"
													viewBox="0 0 16 16">
													<path
														d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z" />
												</svg>
											</button>
										</div>
									</div>

									<!-- Card Body -->
									<div class="card-body p-2 d-flex flex-column flex-grow-1">
										<h5 class="fw-bold mb-2 text-dark" style="font-size:16px;">
											{{ Str::limit($data->title ?? 'Daily Current Affairs Boost', 50) }}
										</h5>
										<p class="text-muted small mb-3 flex-grow-1">
											{{ Str::limit($data->description ?? 'Quick daily update on trending current affairs topics for competitive exams.', 100) }}
										</p>
										<div class="mt-auto">
											<button type="button" class="btn btn-outline-primary rounded-pill w-100"
												data-bs-toggle="modal" data-bs-target="#videoModal"
												data-video-url="{{ $data->youtube_url }}">
												Watch Video
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					@endforeach
				</div>

				<!-- View All Button -->
				@if($dailyBoosts->count() > 0)
					<div class="col-12 text-center mt-5">
						<div class="bottom-box">
							<a href="{{ route('daily.boost.front') }}" class="theme-btn btn-style-three btn-lg px-5">
								<span class="txt">View All Videos</span>
							</a>
						</div>
					</div>
				@endif
			</div>
		</section>
		<!-- End Daily Booster Section -->

		<!-- Start Team Section -->
		<section class="courses-section teacher-f">
			<div class="auto-container">
				<div class="top-content-osd">
					<h2>Adhyayanam IAS</h2>
					<div class="crack-any">
						Crack any government exam with <b>India's Super Teachers</b>
					</div>
					<div class="learn-frm">
						Learn from India's Best Teachers for
						<span class="clr-r">competitive exams</span>
					</div>
				</div>

				<div class="clearfix osd">
					@foreach($teams as $team)
						<div class="main-cont-teacher">
							<div class="t-box">

								<div class="t-img">
									<img src="{{ asset('storage/' . $team->profile_image) }}" alt="{{ $team->name }}">
								</div>

								<div class="t-name">{{ $team->name }}</div>

								{{-- Designation --}}
								@if($team->designation)
									<div class="t-designation">
										{{ $team->designation }}
									</div>
								@endif

								{{-- Experience --}}
								@if($team->experience)
									<div class="t-experience">
										Experience: {{ $team->experience }}
									</div>
								@endif

								{{-- Qualification --}}
								@if($team->education)
									<div class="t-qualification">
										Qualification: {{ $team->education }}
									</div>
								@endif

							</div>
						</div>
					@endforeach
				</div>
			</div>
		</section>
		<!-- End Team Section -->

		<!-- Start Testimonial Section -->
		<section class="newupdate-testimonials py-5 " style="background:#f8fbff;">
			<div class="auto-container">
				<!-- Title -->
				<div class="sec-title text-center mb-5">
					<h2 class="main-heading">{{ $pageContent['testimonials'] ?? 'DOur Successful Best Students' }}</h2>
					<p class="sub-heading">{{ $pageSubContent['testimonials'] ?? "Real stories from our toppers"}}</p>
				</div>

				<!-- Testimonial Slider / Grid -->
				<div class="row g-4">
					<!-- Testimonial 1 -->
					@foreach($testimonials as $data)
						<div class="col-lg-4 col-md-6">
							<div
								class="newupdate-testimonial-card rounded-4 shadow bg-white p-4 h-100 position-relative hover-lift">
								<!-- Large Quote Icons -->
								<div class="quote-open position-absolute top-0 start-0 mt-3 ms-4 text-primary opacity-25 fs-1">“
								</div>
								<div
									class="quote-close position-absolute bottom-0 end-0 mb-3 me-4 text-primary opacity-25 fs-1">
									”</div>

								<!-- Photo + Name + Designation -->
								<div class="d-flex align-items-center mb-4">
									<img src="{{url('uploads/feed-photos/' . $data->photo)}}" alt="{{ $data->username }}"
										class="rounded-circle me-3 shadow-sm"
										style="width: 70px; height: 70px; object-fit: cover; border: 3px solid #0d6efd;" />
									<div>
										<h5 class="fw-bold mb-0">{{ $data->username }}</h5>
										<small class="text-muted">{{ $data->designation }}</small>
										<div class="stars text-warning">
											{!! str_repeat('★', $data->rating) !!}
										</div>
									</div>
								</div>

								<!-- Testimonial Text -->
								<p class="text-muted lh-lg mb-0">
									{{ $data->message }}
								</p>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</section>
		<!-- End Testimonial Section -->

		<!-- start institute highlight Section -->
		@php
			$institute_highlight = App\Models\InstituteHighlight::with('points')->first();
		@endphp

		@if($institute_highlight)
			<section class="newprog-section py-5 bg-white">
				<div class="auto-container">
					<div class="row g-5 align-items-center">

						<!-- Left: Image Column -->
						<div class="col-lg-6 col-md-12">
							<div class="newprog-image-wrapper text-center text-lg-start">
								<div
									class="newprog-image-frame rounded-4 overflow-hidden shadow-lg bg-white p-3 border border-light">
									<img src="{{ $institute_highlight->image
				? asset('storage/' . $institute_highlight->image)
				: asset('images/default.jpg') }}" alt="{{ $institute_highlight->title }}" class="img-fluid rounded-3 w-100"
										style="min-height: 380px; object-fit: cover;" />
								</div>
							</div>
						</div>

						<!-- Right: Content Column -->
						<div class="col-lg-6 col-md-12">
							<div class="newprog-content">

								<div class="newprog-subtitle text-primary fw-medium mb-2">
									{{ $institute_highlight->sub_title }}
								</div>

								<h2 class="newprog-title fw-bold mb-4">
									{{ $institute_highlight->main_heading }}
								</h2>

								<p class="newprog-description text-muted mb-4 lh-lg">
									{!! $institute_highlight->short_description !!}
								</p>

								@if($institute_highlight->sub_sub_title)
									<p class="newprog-feature fw-bold text-dark mb-4">
										<strong>{{ $institute_highlight->sub_sub_title }}</strong>
									</p>
								@endif

								<div class="row g-3 mb-5">
									@php
										$bgColors = ['#e6f0ff', '#eaffea', '#f3e6ff', '#fff3e6', '#e6fff9'];
										$circleColors = ['bg-success', 'bg-warning', 'bg-info', 'bg-primary', 'bg-danger'];
									@endphp

									@if($institute_highlight->points && $institute_highlight->points->count())
										@foreach($institute_highlight->points as $index => $point)

											<div class="col-md-12">
												<div class="newprog-number-card rounded-3 p-3 text-center hover-lift shadow-sm"
													style="background: {{ $bgColors[$index % count($bgColors)] }};">

													<div class="newprog-number-circle {{ $circleColors[$index % count($circleColors)] }} text-white
																																															rounded-circle d-flex align-items-center justify-content-center"
														style="width:40px;height:40px;font-size:1.2rem;font-weight:bold;">
														{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
													</div>

													<p class="mb-0 fw-medium text-dark fs-5">
														{{ $point->comment }}
													</p>
												</div>
											</div>

										@endforeach
									@endif

								</div>
							</div>
						</div>
					</div>

					<!-- CTA -->
					<div class="newprog-cta-box mt-2">
						<div class="newprog-cta-wrapper rounded-4 overflow-hidden shadow-lg">
							<div class="d-flex align-items-center justify-content-between px-5 py-4 flex-wrap gap-4">

								<h4 class="fw-bold text-black mb-0 lh-base" style="font-size: 1.6rem;">
									Let's find the perfect service for your goals
								</h4>

								<a href="#"
									class="newprog-cta-pill btn rounded-pill px-5 py-3 fw-medium d-flex align-items-center gap-2 shadow"
									style="background: linear-gradient(90deg, #10b981, #34d399); color: white; border: none;">
									Book Your Free Consultation
									<i class="bi bi-arrow-right fs-5"></i>
								</a>

							</div>
						</div>
					</div>

				</div>
			</section>
		@endif
		<!-- End institute highlight Section -->

		<!-- start blog Section -->
		<section class="news-section osd" style="height: fit-content;">
			<div class="icon-one" style="background-image: url(images/icons/icon-1.png)"></div>
			<div class="icon-two" style="background-image: url(images/icons/icon-1.png)"></div>
			<div class="container" style="padding:30px;">

				<div class="sec-title centered">
					<h2 class="main-heading">{{ $pageContent['blogs'] ?? 'Blogs' }}</h2>
					<p class="sub-heading">
						{{ $pageSubContent['blogs'] ?? "Learn more from our news and articles"}}
					</p>
				</div>

				<div class="swiper mySwiper">
					<div class="swiper-wrapper">
						@foreach($blogs as $blog)
							<div class="swiper-slide">
								<div class="news-block">
									<div class="inner-box wow fadeInLeft animated" data-wow-delay="0ms"
										data-wow-duration="1500ms"
										style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInLeft;">
										<div class="image">
											@if($blog->thumbnail)
												<a href="{{route('blog.details', $blog->id)}}"><img
														src="{{url('storage/' . $blog->thumbnail)}}" alt="{{$blog->heading}}" /></a>
											@else
												<a href="{{route('blog.details', $blog->id)}}"><img
														src="{{url('storage/' . $blog->image)}}" alt="{{$blog->heading}}" /></a>
											@endif
										</div>
										<div class="lower-content">
											<div class="tag">{{$blog->type}}</div>
											<ul class="post-info">
												<li>By {{$blog->user->name}}</li>
												<li>{{ Carbon\Carbon::parse($blog->created_at)->format('d M Y') }}</li>
											</ul>
											<h5><a href="{{route('blog.details', $blog->id)}}">
													{{ Illuminate\Support\Str::limit($blog->heading, 40) }}</a></h5>
											<div class="text">
												{{ Illuminate\Support\Str::limit($blog->short_description, 60) }}...
											</div>
											<a class="more-post" href="{{route('blog.details', $blog->id)}}">Read more</a>
										</div>
									</div>
								</div>
							</div>
						@endforeach
					</div>
					<!--<div class="swiper-button-next"></div>-->
					<!--<div class="swiper-button-prev"></div>-->
					<!--<div class="swiper-pagination"></div>-->
					<div class="swiper-scrollbar"></div>
				</div>
			</div>
		</section>
		<!-- End blog Section -->

		<!-- start faq Section -->
		<section class="faq-section">

			<div class="faq-container">

				<!-- LEFT SIDE FAQ -->
				<div class="faq-left">

					<h2 class="faq-title">{{ $pageContent['faq'] ?? 'Frequently Asked Questions' }}</h2>

					<div class="faq-box">

						@foreach($faqs as $faq)
							<div class="faq-item">
								<div class="faq-question-row">
									<h3 class="faq-question">{{ $faq->question }}</h3>
									<span class="faq-icon">+</span>
								</div>
								<div class="faq-answer">
									{{ $faq->answer }}
								</div>
							</div>
						@endforeach

					</div>
				</div>

				<!-- RIGHT SIDE ENQUIRY FORM -->
				<div class="faq-right">

					<div class="faq-form-card">

						<h2 class="faq-form-title">Send Us an Enquiry</h2>
						<p class="faq-form-sub">
							Have questions? Need help? Submit your enquiry and our team will reach out soon.
						</p>
						@if(session('success'))
							<div class="alert alert-success">
								{{ session('success') }}
							</div>
						@endif
						<form class="faq-form" id="homeenquiryForm" method="POST" action="{{ route('home.enquiry') }}">
							@csrf
							<input type="text" class="faq-input" name="full_name" placeholder="Full Name"
								value="{{ old('full_name') }}">

							<input type="email" name="email_address" id="email-address" class="faq-input"
								placeholder="Email Address" value="{{ old('email_address') }}">

							<div class="faq-phone-group">
								<select class="faq-country" name="country_code">
									<option value="+91">🇮🇳 +91</option>
									<option value="+93">🇦🇫 +93</option>
									<option value="+880">🇧🇩 +880</option>
									<option value="+975">🇧🇹 +975</option>
									<option value="+94">🇱🇰 +94</option>
									<option value="+92">🇵🇰 +92</option>
									<option value="+977">🇳🇵 +977</option>
									<option value="+1">🇺🇸 +1</option>
									<option value="+44">🇬🇧 +44</option>
									<option value="+971">🇦🇪 +971</option>
								</select>

								<input type="text" class="faq-input phone-input" name="mobile_number" id="mobile-number"
									placeholder="Mobile Number" value="{{ old('mobile_number') }}">
							</div>


							<textarea name="message" class="faq-textarea" rows="4"
								placeholder="Write your message...">{{ old('message') }}</textarea>
							<div class="col-md-12">
								<!-- <div class="g-recaptcha mb-2" data-sitekey={{ config('services.recaptcha.key') }}></div> -->
							</div>

							<button type="submit" class="faq-btn">Submit Enquiry</button>

						</form>

					</div>

				</div>

			</div>

		</section>
		<!-- End faq Section -->

		<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
		<script>
			var swiper = new Swiper(".mySwiper", {
				slidesPerView: 1, // Display one slide per view
				spaceBetween: 20, // Adjust spacing between slides
				breakpoints: {
					768: {
						slidesPerView: 4, // Display three slides per view on desktop
						spaceBetween: 40, // Adjust spacing between slides on desktop
					}
				},
				scrollbar: {
					el: ".swiper-scrollbar",
					hide: true,
				},
				autoplay: {
					delay: 5000, // Autoplay delay in milliseconds
					disableOnInteraction: false, // Continue autoplay even when user interacts with swiper
				},
			});
		</script>
		<script>
			$(function () {
				var overlay = $('<div id="overlay"></div>');
				@if(isset($popup) && isset($popup->pop_image))
					// Show the overlay
					overlay.show();
					overlay.appendTo(document.body);
					$('.popup-onload').show();
				@endif
				$('.close').click(function () {
					$('.popup-onload').hide();
					overlay.appendTo(document.body).remove();
					return false;
				});




				$('.x').click(function () {
					$('.popup').hide();
					overlay.appendTo(document.body).remove();
					return false;
				});
			});
		</script>
		<script>
			document.addEventListener('DOMContentLoaded', function () {
				const videoModal = document.getElementById('videoModal');
				const videoIframe = document.getElementById('videoIframe');

				// When modal opens → set src with autoplay
				videoModal.addEventListener('show.bs.modal', function (event) {
					const button = event.relatedTarget; // button that triggered modal
					const videoUrl = button.getAttribute('data-video-url');

					// Convert normal YouTube URL to embed URL + autoplay
					let embedUrl = videoUrl.replace('watch?v=', 'embed/');
					if (embedUrl.includes('youtu.be/')) {
						embedUrl = embedUrl.replace('youtu.be/', 'youtube.com/embed/');
					}
					embedUrl += (embedUrl.includes('?') ? '&' : '?') + 'autoplay=1&rel=0&modestbranding=1';

					videoIframe.src = embedUrl;
				});

				// When modal closes → remove src to stop video
				videoModal.addEventListener('hidden.bs.modal', function () {
					videoIframe.src = '';
				});
			});
		</script>
		<script>
			$('.main-slider-carousel').owlCarousel({
				items: 1,
				loop: true,
				autoplay: true,
				autoplayTimeout: 3500,
				autoplayHoverPause: true,
				animateOut: 'fadeOut',
				smartSpeed: 800
			});

		</script>
		<script>
			const noticeArea = document.getElementById("noticeArea");
			const notices = Array.from(noticeArea.children);
			let currentIndex = 0;

			// Show only first 5
			function showInitialNotices() {
				notices.forEach((item, i) => {
					item.style.display = i < 5 ? "flex" : "none";
				});
			}
			showInitialNotices();

			// Auto fade + new notice add
			function nextNotice() {
				let fadeItem = notices[currentIndex];
				fadeItem.classList.add("fade-out");

				setTimeout(() => {
					fadeItem.style.display = "none";
					fadeItem.classList.remove("fade-out");

					let next = notices[(currentIndex + 5) % notices.length];
					next.style.display = "flex";
					next.classList.add("fade-in");

					setTimeout(() => {
						next.classList.add("active");
					}, 50);

					currentIndex = (currentIndex + 1) % notices.length;
				}, 400);
			}

			// Auto-scroll every 3 seconds
			let autoScroll = setInterval(nextNotice, 3000);

			// Hover pause
			noticeArea.addEventListener("mouseenter", () => clearInterval(autoScroll));
			noticeArea.addEventListener("mouseleave", () => autoScroll = setInterval(nextNotice, 3000));

			// Footer manual scroll
			document.getElementById("scrollUp").onclick = nextNotice;
			document.getElementById("scrollDown").onclick = nextNotice;

		</script>
		<script>
			document.querySelectorAll('.newtab-wrapper').forEach(wrapper => {

				const tabs = wrapper.querySelectorAll('.newtab-item');

				// find cards ONLY inside the same section
				const section = wrapper.closest('section');
				const cards = section.querySelectorAll('[data-commission]');

				function showLimitedCards(commission) {
					let count = 0;

					cards.forEach(card => {

						const matches =
							commission === 'all' ||
							card.dataset.commission === commission;

						if (matches && count < 8) {
							card.style.display = "";
							count++;
						} else {
							card.style.display = "none";
						}

					});
				}

				// 🔹 default load (show first 8 of ALL)
				showLimitedCards('all');

				tabs.forEach(tab => {
					tab.addEventListener('click', () => {

						tabs.forEach(t => t.classList.remove('active'));
						tab.classList.add('active');

						const commission = tab.dataset.tab;

						showLimitedCards(commission);
					});
				});

			});
		</script>
		<script>
			document.addEventListener('DOMContentLoaded', function () {
				const videoModal = document.getElementById('videoModal');
				if (videoModal) {
					videoModal.addEventListener('show.bs.modal', function (event) {
						const button = event.relatedTarget;
						const videoUrl = button.getAttribute('data-video-url');
						const iframe = document.getElementById('videoIframe');

						// Convert normal YouTube URL to embed format if needed
						let embedUrl = videoUrl;
						if (videoUrl.includes('youtube.com/watch?v=')) {
							const videoId = videoUrl.split('v=')[1]?.split('&')[0];
							embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
						} else if (videoUrl.includes('youtu.be/')) {
							const videoId = videoUrl.split('youtu.be/')[1]?.split('?')[0];
							embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
						}

						iframe.src = embedUrl;
					});

					// Reset iframe when modal closes (stops video)
					videoModal.addEventListener('hidden.bs.modal', function () {
						document.getElementById('videoIframe').src = '';
					});
				}
			});
		</script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

		<!-- Owl Carousel CSS -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
		<link rel="stylesheet"
			href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
		<script>
			$(document).ready(function () {
				$(".newupdate-testimonial-carousel").owlCarousel({
					loop: true,
					margin: 30,
					nav: true,
					dots: true,
					autoplay: true,
					autoplayTimeout: 6000,
					autoplayHoverPause: true,
					responsive: {
						0: {
							items: 1
						},
						768: {
							items: 2
						},
						1200: {
							items: 2
						}
					}
				});
			});


		</script>
		<script>
			document.querySelectorAll(".faq-item").forEach(item => {
				item.addEventListener("click", () => {

					// Close all if you want only one open at a time
					document.querySelectorAll(".faq-item").forEach(i => {
						if (i !== item) {
							i.classList.remove("active");
							i.querySelector(".faq-icon").textContent = "+";
							i.querySelector(".faq-answer").style.display = "none";
						}
					});

					// Toggle current
					item.classList.toggle("active");

					let icon = item.querySelector(".faq-icon");
					let answer = item.querySelector(".faq-answer");

					if (item.classList.contains("active")) {
						icon.textContent = "-";
						answer.style.display = "block";
					} else {
						icon.textContent = "+";
						answer.style.display = "none";
					}
				});
			});
		</script>

		<script>
			// Yeh object sab commissions ke categories ka name rakhega
			window.commissionCategories = {
				@foreach($commissions as $commission)
												  "{{ $commission->id }}": {
					@foreach($commission->categories as $cat)
						  "{{ $cat->id }}": "{{ addslashes($cat->name) }}",
					@endforeach
												  },
				@endforeach
								  };


			document.addEventListener('DOMContentLoaded', function () {
				const commissionTabs = document.querySelectorAll('#commissionTabs .nav-link');
				const subCategoryTabsContainer = document.getElementById('subCategoryTabs');
				const allCards = document.querySelectorAll('.testseries-card');

				// Commission change hone pe sub-tabs generate karo
				commissionTabs.forEach(tab => {
					tab.addEventListener('shown.bs.tab', function () {
						const commissionId = this.getAttribute('data-commission-id');
						subCategoryTabsContainer.innerHTML = ''; // Purane tabs clear

						// "All" tab add karo (active by default)
						const allTabLi = document.createElement('li');
						allTabLi.className = 'nav-item';
						allTabLi.innerHTML = `
										<button class="btn btn-outline-secondary btn-sm11 active" data-category="all">
										  All
										</button>
									  `;
						subCategoryTabsContainer.appendChild(allTabLi);

						// Categories collect karo (unique)
						const categories = new Set();
						allCards.forEach(card => {
							if (card.getAttribute('data-commission') === commissionId.toLowerCase()) {
								const catId = card.getAttribute('data-category');
								if (catId && catId !== 'all') categories.add(catId);
							}
						});

						// Sub-category buttons add karo
						// Sub-category buttons add karo (updated)
						categories.forEach(catId => {
							const categoryName = window.commissionCategories[commissionId]?.[catId] || `Category ${catId}`;

							const li = document.createElement('li');
							li.className = 'nav-item';
							li.innerHTML = `
									<button class="btn btn-outline-secondary btn-sm11" data-category="${catId}">
									  ${categoryName}
									</button>
								  `;
							subCategoryTabsContainer.appendChild(li);
						});

						// "All" tab ko programmatically active karo
						allTabLi.querySelector('button').click();
					});
				});

				// Sub-category click pe filter + active class handle
				subCategoryTabsContainer.addEventListener('click', function (e) {
					if (e.target.tagName === 'BUTTON') {
						// Pehle sab buttons se active class hatao
						subCategoryTabsContainer.querySelectorAll('button').forEach(btn => {
							btn.classList.remove('active');
						});

						// Clicked button ko active banao
						e.target.classList.add('active');

						// Filter logic
						const selectedCategory = e.target.getAttribute('data-category');
						const activeCommissionTab = document.querySelector('#commissionTabs .nav-link.active');
						const commissionId = activeCommissionTab?.getAttribute('data-commission-id')?.toLowerCase();

						let count = 0;

						allCards.forEach(card => {

							const cardCommission = card.getAttribute('data-commission');
							const cardCategory = card.getAttribute('data-category');

							if (cardCommission === commissionId) {

								if ((selectedCategory === 'all' || cardCategory === selectedCategory) && count < 6) {
									card.style.display = 'block';
									count++;
								} else {
									card.style.display = 'none';
								}

							} else {
								card.style.display = 'none';
							}

						});
					}
				});

				// Page load pe pehla commission automatically select karo
				// Force trigger for first tab on page load
				if (commissionTabs.length > 0) {
					const firstTab = commissionTabs[0];
					const bsTab = new bootstrap.Tab(firstTab);
					bsTab.show();

					// manually dispatch event so logic runs
					firstTab.dispatchEvent(new Event('shown.bs.tab'));
				}
			});

			document.addEventListener('DOMContentLoaded', function () {
				const commissionTabs = document.querySelectorAll('#commissionTabsCourses .nav-link');
				const subCategoryTabsContainer = document.getElementById('subCategoryTabsCourses');
				const allCards = document.querySelectorAll('.edu-course-card');

				commissionTabs.forEach(tab => {
					tab.addEventListener('shown.bs.tab', function () {
						const commissionId = this.getAttribute('data-commission-id').toLowerCase();
						subCategoryTabsContainer.innerHTML = '';

						// All Courses tab
						const allTabLi = document.createElement('li');
						allTabLi.className = 'nav-item';
						allTabLi.innerHTML = `
										<button class="btn btn-outline-secondary btn-sm11 active" data-category="all">
										  All Courses
										</button>
									  `;
						subCategoryTabsContainer.appendChild(allTabLi);

						// Categories collect with names from data-attribute
						const categoryMap = new Map();
						allCards.forEach(card => {
							if (card.getAttribute('data-commission') === commissionId) {
								const catId = card.getAttribute('data-category');
								const catName = card.getAttribute('data-category-name') || `Category ${catId}`;
								if (catId && catId !== 'all') {
									categoryMap.set(catId, catName);
								}
							}
						});

						// Buttons banao
						categoryMap.forEach((catName, catId) => {
							const li = document.createElement('li');
							li.className = 'nav-item';
							li.innerHTML = `
										  <button class="btn btn-outline-secondary btn-sm11" data-category="${catId}">
											${catName}
										  </button>
										`;
							subCategoryTabsContainer.appendChild(li);
						});

						// All tab trigger
						allTabLi.querySelector('button').click();
					});
				});

				// Filter + active class
				subCategoryTabsContainer.addEventListener('click', function (e) {
					if (e.target.tagName === 'BUTTON') {
						subCategoryTabsContainer.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
						e.target.classList.add('active');

						const selectedCategory = e.target.getAttribute('data-category');
						const activeTab = document.querySelector('#commissionTabsCourses .nav-link.active');
						const commissionId = activeTab?.getAttribute('data-commission-id')?.toLowerCase();

						let count = 0;

						allCards.forEach(card => {
							const cardComm = card.getAttribute('data-commission');
							const cardCat = card.getAttribute('data-category');

							if (cardComm === commissionId) {

								if ((selectedCategory === 'all' || cardCat === selectedCategory) && count < 6) {
									card.style.display = 'block';
									count++;
								} else {
									card.style.display = 'none';
								}

							} else {
								card.style.display = 'none';
							}
						});
					}
				});

				// Force trigger for first tab on page load
				if (commissionTabs.length > 0) {
					const firstTab = commissionTabs[0];
					const bsTab = new bootstrap.Tab(firstTab);
					bsTab.show();

					// manually dispatch event so logic runs
					firstTab.dispatchEvent(new Event('shown.bs.tab'));
				}
			});

		</script>
	</body>
@endsection