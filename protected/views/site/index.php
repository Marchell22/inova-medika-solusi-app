<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' - Selamat Datang';
?>

<div class="landing-container">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1>Selamat Datang di Inova Medika Solusi</h1>
            <p class="hero-subtitle">Sistem Informasi Manajemen Kesehatan Terpadu</p>
            <div class="hero-buttons">
                <a href="<?php echo Yii::app()->createUrl('site/login'); ?>" class="btn btn-primary">Login</a>
                <a href="#features" class="btn btn-secondary">Pelajari Lebih Lanjut</a>
            </div>
        </div>
        <div class="hero-image">
            <!-- Placeholder for hero image -->
            <div class="image-placeholder">
                <i class="icon-medical"></i>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <h2 class="section-title">Fitur Unggulan</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="icon-user-md"></i>
                </div>
                <h3>Manajemen Pasien</h3>
                <p>Kelola data pasien dengan mudah dan efisien. Akses riwayat medis dengan cepat.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="icon-calendar"></i>
                </div>
                <h3>Jadwal Dokter</h3>
                <p>Atur jadwal praktik dokter dan reservasi pasien tanpa bentrok.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="icon-heartbeat"></i>
                </div>
                <h3>Rekam Medis</h3>
                <p>Simpan dan akses catatan medis pasien dengan aman dan terorganisir.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="icon-pills"></i>
                </div>
                <h3>Inventaris Obat</h3>
                <p>Kelola stok obat dan perlengkapan medis dengan sistem terintegrasi.</p>
            </div>
        </div>
    </section>

</div>

<style>
/* Reset CSS */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Landing Page Container */
.landing-container {
    width: 100%;
    color: #333;
}

/* Section Styling */
section {
    padding: 60px 5%;
}

.section-title {
    text-align: center;
    margin-bottom: 40px;
    color: #2c3e50;
    font-size: 28px;
    position: relative;
}

.section-title:after {
    content: '';
    display: block;
    width: 50px;
    height: 3px;
    background: #3498db;
    margin: 15px auto;
}

/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, #f5f7fa 0%, #e4efe9 100%);
    display: flex;
    align-items: center;
    min-height: 500px;
    padding: 80px 5%;
}

.hero-content {
    flex: 1;
    padding-right: 40px;
}

.hero-content h1 {
    font-size: 36px;
    color: #2c3e50;
    margin-bottom: 20px;
    line-height: 1.2;
}

.hero-subtitle {
    font-size: 18px;
    color: #7f8c8d;
    margin-bottom: 30px;
}

.hero-buttons {
    display: flex;
    gap: 15px;
}

.hero-image {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.image-placeholder {
    width: 100%;
    max-width: 400px;
    height: 300px;
    background-color: #ecf0f1;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.image-placeholder.secondary {
    background-color: #e8f4fc;
}

/* Icons */
[class^="icon-"] {
    font-size: 60px;
    color: #3498db;
}

.icon-medical:before { content: "🏥"; }
.icon-user-md:before { content: "👨‍⚕️"; }
.icon-calendar:before { content: "📅"; }
.icon-heartbeat:before { content: "💓"; }
.icon-pills:before { content: "💊"; }
.icon-hospital:before { content: "🏥"; }

/* Features Section */
.features-section {
    background-color: #fff;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
}

.feature-card {
    background: #fff;
    border-radius: 8px;
    padding: 30px;
    text-align: center;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-5px);
}

.feature-icon {
    margin-bottom: 20px;
}

.feature-card h3 {
    margin-bottom: 15px;
    color: #2c3e50;
}

/* About Section */
.about-section {
    background-color: #f9f9f9;
    display: flex;
    align-items: center;
}

.about-content {
    flex: 1;
    padding-right: 40px;
}

.about-content p {
    margin-bottom: 20px;
    line-height: 1.6;
}

.about-image {
    flex: 1;
}

/* Testimonials Section */
.testimonials-section {
    background-color: #fff;
}

.testimonials-slider {
    display: flex;
    gap: 30px;
    overflow-x: auto;
    padding: 20px 0;
    scroll-snap-type: x mandatory;
}

.testimonial-card {
    min-width: 300px;
    flex: 1;
    background: #fff;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
    scroll-snap-align: start;
}

.testimonial-content {
    margin-bottom: 20px;
}

.testimonial-content p {
    font-style: italic;
    color: #555;
    line-height: 1.6;
}

.testimonial-author {
    display: flex;
    align-items: center;
}

.author-avatar {
    margin-right: 15px;
}

.avatar-placeholder {
    width: 50px;
    height: 50px;
    background: #3498db;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    font-weight: bold;
    font-size: 20px;
}

.author-details h4 {
    margin-bottom: 5px;
    color: #2c3e50;
}

.author-details p {
    color: #7f8c8d;
    font-size: 14px;
}

/* CTA Section */
.cta-section {
    background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
    text-align: center;
    color: white;
    padding: 80px 5%;
    border-radius: 10px;
    margin: 0 5%;
}

.cta-section h2 {
    font-size: 32px;
    margin-bottom: 20px;
}

.cta-section p {
    margin-bottom: 30px;
    font-size: 18px;
    opacity: 0.9;
}

/* Buttons */
.btn {
    display: inline-block;
    padding: 12px 24px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-primary {
    background-color: #3498db;
    color: white;
    border: none;
}

.btn-primary:hover {
    background-color: #2980b9;
}

.btn-secondary {
    background-color: white;
    color: #3498db;
    border: 1px solid #3498db;
}

.btn-secondary:hover {
    background-color: #f5f5f5;
}

.btn-outline {
    background-color: transparent;
    color: #3498db;
    border: 1px solid #3498db;
}

.btn-outline:hover {
    background-color: #3498db;
    color: white;
}

.btn-large {
    padding: 15px 30px;
    font-size: 18px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-section, 
    .about-section {
        flex-direction: column;
    }

    .hero-content,
    .about-content {
        padding-right: 0;
        margin-bottom: 40px;
    }

    .hero-buttons {
        flex-direction: column;
        gap: 10px;
    }

    .testimonials-slider {
        flex-direction: column;
    }

    .testimonial-card {
        min-width: auto;
    }
}
</style>