@extends('front.partials.app')
<!-- Free version (yeh use kar rahe ho toh fa-file-pdf nahi milega) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<!-- Agar pro version use kar rahe ho toh yeh link hona chahiye -->
<link rel="stylesheet" href="https://kit.fontawesome.com/your-kit-code.js">
@section('content')

<style>

/* container */

.ts-container{
width:90%;
max-width:1200px;
margin:auto;
}

/* ---------------- BANNER ---------------- */

.ts-banner{
background:linear-gradient(135deg,#eef2ff,#f7f9ff);
padding:50px 0 90px 0;
position:relative;
overflow:visible;
}

.ts-banner-content{
max-width:650px;
}

.ts-banner h1{
font-size:40px;
font-weight:700;
margin-bottom:-15px;
}

.ts-banner p{
color:#555;
line-height:1.6;
}

/* stats */

.ts-stats{
display:flex;
gap:20px;
margin-top:30px;
flex-wrap:wrap;
}

.ts-stat{
background:white;
padding:15px 25px;
border-radius:12px;
box-shadow:0 6px 18px rgba(0,0,0,0.08);
font-weight:600;
}

/* ---------------- PRICE CARD ---------------- */

.price-card{
    padding:12px;
position:absolute;
right:120px;
top:120px;
width:320px;
background:white;
border-radius:16px;
box-shadow:0 15px 40px rgba(0,0,0,0.15);
overflow:hidden;
}



.price-card img{
width:100%;
height:180px;
object-fit:cover;
}

.price-content{
padding:25px;
text-align:center;
}

.price{
font-size:32px;
font-weight:700;
color:#045279;
}

.old{
text-decoration:line-through;
color:#999;
font-size:16px;
margin-left:8px;
}

.discount{
color:#ff3b3b;
margin:8px 0;
}

.buy-btn{
background:linear-gradient(135deg,#045279,#7a8dff);
color:white;
border:none;
padding:12px 25px;
border-radius:8px;
cursor:pointer;
width:100%;
margin-top:10px;
}

/* ---------------- TOPIC BUTTON CARDS ---------------- */

.topics-wrapper{
background:white;
padding:35px;
border-radius:18px;
box-shadow:0 10px 25px rgba(0,0,0,0.08);
margin-top:70px;
}

.topics-wrapper h2{
margin-bottom:25px;
}

.topics-grid{
display:grid;
grid-template-columns:repeat(2,1fr);
gap:18px;
}

.topic-btn{
display:flex;
align-items:center;
gap:15px;
background:#f7f9ff;
border:none;
padding:18px;
border-radius:12px;
text-align:left;
cursor:pointer;
transition:.3s;
box-shadow:0 4px 12px rgba(0,0,0,0.06);
}

.topic-btn:hover{
transform:translateY(-3px);
box-shadow:0 8px 18px rgba(0,0,0,0.12);
}

.topic-icon{
font-size:28px;
background:#eef2ff;
padding:10px;
border-radius:10px;
}

.topic-content h4{
margin:0;
font-size:17px;
}

.topic-content p{
margin:3px 0;
font-size:13px;
color:#666;
}

.topic-content span{
font-size:12px;
font-weight:600;
color:#045279;
}

/* different colors */

.c1{background:linear-gradient(135deg,#5f7cff,#7fa4ff);}
.c2{background:linear-gradient(135deg,#ff7c7c,#ff9f9f);}
.c3{background:linear-gradient(135deg,#2dd4bf,#5eead4);}
.c4{background:linear-gradient(135deg,#fbbf24,#fcd34d);}
.c5{background:linear-gradient(135deg,#a78bfa,#c4b5fd);}

/* ---------------- FEATURE CARD ---------------- */

.feature-card{
margin-top:70px;
background:white;
padding:35px;
border-radius:18px;
box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.feature-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
gap:20px;
margin-top:20px;
}

.feature-grid div{
display:flex;
align-items:center;
gap:10px;
}

.feature-grid i{
color:#045279;
}

/* ---------------- NOTES ---------------- */

.notes-card{
background:white;
padding:35px;
border-radius:16px;
box-shadow:0 10px 25px rgba(0,0,0,0.08);
margin:50px 0;

}

.notes-card h3{
margin-bottom:10px;
}

.notes-card hr{
border:none;
height:1px;
background:#eee;
margin-bottom:20px;
}

.notes-list{
list-style:none;
padding:0;
margin:0;
}

.notes-list li{
display:flex;
align-items:flex-start;
gap:10px;
margin-bottom:12px;
color:#444;
}

.notes-list span{
color:#045279;
font-weight:700;
}


/* ---------------- TERMS ---------------- */

.terms{
margin-top:30px;
background:white;
padding:30px;
border-radius:15px;
box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

/* breadcrumb */

.ts-breadcrumb{
display:flex;
align-items:center;
flex-wrap:wrap;
gap:6px;
margin:10px 0 20px 0;
font-size:14px;
}

.ts-breadcrumb a{
color:#045279;
text-decoration:none;
font-weight:500;
}

.ts-breadcrumb a:hover{
text-decoration:underline;
}

.arrow{
color:#888;
font-size:16px;
margin:0 3px;
}

.current{
color:#555;
font-weight:600;
}


/* details section */

.details-card{
margin-top:70px;
background:white;
padding:35px;
border-radius:18px;
box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.details-desc{
margin-top:10px;
color:#555;
line-height:1.6;
max-width:800px;
}

.details-points{
display:grid;
grid-template-columns:repeat(3,1fr);
gap:15px;
margin-top:25px;
}

.detail-btn{
display:flex;
align-items:center;
gap:10px;
border:none;
background:#f7f9ff;
padding:14px;
border-radius:10px;
cursor:pointer;
font-weight:600;
transition:.3s;
}

.detail-btn i{
color:#045279;
}

.detail-btn:hover{
transform:translateY(-2px);
box-shadow:0 6px 15px rgba(0,0,0,0.1);
}


</style>


<!-- BANNER -->

<section class="ts-banner">

<div class="ts-container">

<div class="ts-banner-content">
    <div class="ts-breadcrumb">

<a href="#">Home</a>

<span class="arrow">›</span>

<a href="#">UPSC</a>

<span class="arrow">›</span>

<a href="#">Prelims</a>

<span class="arrow">›</span>

<span class="current">UPSC Prelims 2026 Test Series</span>

</div>

<h1>UPSC Prelims 2026 Test Series</h1>




<p>
Practice real exam level mock tests designed by expert faculty.
Improve accuracy, speed and boost your All India rank with detailed performance analytics.
</p>

<div class="ts-stats">

<div class="ts-stat">120+ Questions</div>

<div class="ts-stat">15 Mock Tests</div>

<div class="ts-stat">3500+ Students</div>

<div class="ts-stat">365 Days Validity</div>

</div>

</div>

</div>


<!-- PRICE CARD -->

<div class="price-card">

<img src="https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8">

<div class="price-content">

<div class="price">

₹499 <span class="old">₹999</span>

</div>

<p class="discount">50% Limited Offer</p>

<button class="buy-btn">Enroll Now</button>

<p style="margin-top:10px;font-size:13px;">
Validity : 365 Days
</p>

</div>

</div>

</section>


<!-- TOPICS -->

<section class="ts-container topic-section">

<div class="topics-wrapper">

<h2>Topics Covered</h2>

<div class="topics-grid">

<button class="topic-btn">
<div class="topic-icon">📘</div>
<div class="topic-content">
<h4>Polity</h4>
<p>Indian Constitution & Governance</p>
<span>20 Questions</span>
</div>
</button>

<button class="topic-btn">
<div class="topic-icon">📕</div>
<div class="topic-content">
<h4>History</h4>
<p>Ancient & Modern India</p>
<span>25 Questions</span>
</div>
</button>

<button class="topic-btn">
<div class="topic-icon">📊</div>
<div class="topic-content">
<h4>Economics</h4>
<p>Indian Economy Concepts</p>
<span>18 Questions</span>
</div>
</button>

<button class="topic-btn">
<div class="topic-icon">🌿</div>
<div class="topic-content">
<h4>Environment</h4>
<p>Ecology & Biodiversity</p>
<span>12 Questions</span>
</div>
</button>

<button class="topic-btn">
<div class="topic-icon">🔬</div>
<div class="topic-content">
<h4>Science</h4>
<p>General Science</p>
<span>15 Questions</span>
</div>
</button>

</div>

</div>

</section>

<section class="ts-container">

<div class="details-card">

<h2>Test Series Details</h2>

<p class="details-desc">
This test series is specially designed for aspirants preparing for UPSC Prelims examination.
It includes full length mock tests and topic wise practice papers that simulate the real exam environment.
</p>

<div class="details-points">

<button class="detail-btn">
<i class="fa-solid fa-file-lines"></i>
<span>15 Full Length Tests</span>
</button>

<button class="detail-btn">
<i class="fa-solid fa-layer-group"></i>
<span>Topic Wise Practice</span>
</button>

<button class="detail-btn">
<i class="fa-solid fa-chart-line"></i>
<span>Performance Analytics</span>
</button>

<button class="detail-btn">
<i class="fa-solid fa-ranking-star"></i>
<span>All India Rank</span>
</button>

<button class="detail-btn">
<i class="fa-solid fa-clock"></i>
<span>365 Days Validity</span>
</button>

<button class="detail-btn">
<i class="fa-solid fa-mobile-screen"></i>
<span>Mobile Friendly</span>
</button>

</div>

</div>

</section>




<!-- FEATURES -->

<section class="ts-container">

<div class="feature-card">

<h2>Key Features</h2>

<div class="feature-grid">

<div><i class="fa-solid fa-check"></i> Full Length Mock Tests</div>

<div><i class="fa-solid fa-check"></i> Topic Wise Practice Tests</div>

<div><i class="fa-solid fa-check"></i> Detailed Solutions</div>

<div><i class="fa-solid fa-check"></i> Performance Analytics</div>

<div><i class="fa-solid fa-check"></i> All India Ranking</div>

<div><i class="fa-solid fa-check"></i> Real Exam Simulation</div>

</div>

</div>

</section>


<!-- NOTES -->

<section class="ts-container">

<div class="notes-card">

<h3>Important Notes</h3>

<hr>

<ul class="notes-list">

<li>
<span>✔</span>
Tests are designed according to the latest exam pattern.
</li>

<li>
<span>✔</span>
Each question contains detailed explanation.
</li>

<li>
<span>✔</span>
Rank comparison with thousands of students.
</li>

<li>
<span>✔</span>
Attempt tests anytime during validity period.
</li>

</ul>

</div>

</section>



<!-- TERMS -->




@endsection
