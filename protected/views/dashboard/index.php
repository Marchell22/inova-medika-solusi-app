<?php
$this->pageTitle = Yii::app()->name . ' - Dashboard';
$this->breadcrumbs = array(
    'Dashboard',
);
?>

<div class="dashboard-container">
    <div class="dashboard-header">
        <div class="header-left">
            <h1>Dashboard</h1>
            <p class="welcome-message">Selamat datang, <?php echo Yii::app()->user->name; ?>!</p>
        </div>
        <div class="header-right">
            <span class="date-display"><?php echo date('l, d F Y'); ?></span>
            <a href="<?php echo Yii::app()->createUrl('/site/logout'); ?>" class="logout-btn">
                <span class="logout-icon">🚪</span> Logout
            </a>
        </div>
    </div>

    <!-- Summary Boxes -->
    <div class="summary-boxes">
        <?php foreach($summaryData as $summary): ?>
            <div class="summary-box <?php echo 'summary-' . $summary['color']; ?>">
                <div class="summary-icon">
                    <i class="icon-<?php echo $summary['icon']; ?>"></i>
                </div>
                <div class="summary-info">
                    <h3><?php echo $summary['value']; ?></h3>
                    <p><?php echo $summary['title']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="dashboard-content">
        <!-- Left Column -->
        <div class="dashboard-column">
            <div class="dashboard-card">
                <div class="card-header">
                    <h2>Aktivitas Terbaru</h2>
                </div>
                <div class="card-content">
                    <ul class="activity-list">
                        <?php foreach($recentActivities as $activity): ?>
                            <li class="activity-item">
                                <div class="activity-icon activity-<?php echo $activity['type']; ?>">
                                    <i class="icon-activity"></i>
                                </div>
                                <div class="activity-details">
                                    <span class="activity-description"><?php echo $activity['description']; ?></span>
                                    <strong><?php echo $activity['name']; ?></strong>
                                    <span class="activity-time"><?php echo $activity['time']; ?></span>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="#" class="view-all">Lihat Semua Aktivitas</a>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="dashboard-column">
            <div class="dashboard-card">
                <div class="card-header">
                    <h2>Jadwal Hari Ini</h2>
                </div>
                <div class="card-content">
                    <div class="schedule-item">
                        <div class="schedule-time">08:00</div>
                        <div class="schedule-details">
                            <div class="schedule-title">Pemeriksaan Rutin</div>
                            <div class="schedule-desc">Dr. Hadi dengan pasien Rini</div>
                        </div>
                    </div>
                    <div class="schedule-item">
                        <div class="schedule-time">09:30</div>
                        <div class="schedule-details">
                            <div class="schedule-title">Konsultasi</div>
                            <div class="schedule-desc">Dr. Maya dengan pasien Tono</div>
                        </div>
                    </div>
                    <div class="schedule-item">
                        <div class="schedule-time">11:00</div>
                        <div class="schedule-details">
                            <div class="schedule-title">Rapat Staf</div>
                            <div class="schedule-desc">Ruang Rapat Utama</div>
                        </div>
                    </div>
                    <div class="schedule-item">
                        <div class="schedule-time">13:30</div>
                        <div class="schedule-details">
                            <div class="schedule-title">Operasi</div>
                            <div class="schedule-desc">Dr. Surya - Ruang Operasi 2</div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="#" class="view-all">Lihat Semua Jadwal</a>
                </div>
            </div>
            
            <div class="dashboard-card">
                <div class="card-header">
                    <h2>Statistik Cepat</h2>
                </div>
                <div class="card-content">
                    <div class="quick-stats">
                        <div class="stat-item">
                            <div class="stat-label">Tingkat Hunian</div>
                            <div class="stat-value">85%</div>
                            <div class="progress-bar">
                                <div class="progress" style="width: 85%;"></div>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Jumlah Dokter Hadir</div>
                            <div class="stat-value">7/8</div>
                            <div class="progress-bar">
                                <div class="progress" style="width: 87%; background-color: #2ecc71;"></div>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Kepuasan Pasien</div>
                            <div class="stat-value">92%</div>
                            <div class="progress-bar">
                                <div class="progress" style="width: 92%; background-color: #3498db;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Dashboard Styles */
.dashboard-container {
    padding: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f5f7f9;
    min-height: 100vh;
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 1px solid #e1e5e8;
}

.header-left h1 {
    font-size: 24px;
    color: #333;
    margin: 0 0 5px 0;
}

.welcome-message {
    color: #666;
    font-size: 14px;
}

.header-right {
    display: flex;
    align-items: center;
}

.date-display {
    margin-right: 20px;
    color: #666;
    font-size: 14px;
}

.logout-btn {
    display: flex;
    align-items: center;
    padding: 8px 16px;
    background-color: #f5f5f5;
    color: #333;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s;
}

.logout-btn:hover {
    background-color: #e0e0e0;
}

.logout-icon {
    margin-right: 6px;
}

/* Summary Boxes */
.summary-boxes {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
    gap: 20px;
    margin-bottom: 25px;
}

.summary-box {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    padding: 20px;
    display: flex;
    align-items: center;
    transition: transform 0.2s, box-shadow 0.2s;
}

.summary-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.12);
}

.summary-primary { border-left: 4px solid #3498db; }
.summary-success { border-left: 4px solid #2ecc71; }
.summary-info { border-left: 4px solid #3498db; }
.summary-warning { border-left: 4px solid #f1c40f; }
.summary-danger { border-left: 4px solid #e74c3c; }

.summary-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    font-size: 22px;
    color: white;
}

.summary-primary .summary-icon { background-color: #3498db; }
.summary-success .summary-icon { background-color: #2ecc71; }
.summary-info .summary-icon { background-color: #3498db; }
.summary-warning .summary-icon { background-color: #f1c40f; }
.summary-danger .summary-icon { background-color: #e74c3c; }

.summary-info h3 {
    font-size: 24px;
    margin: 0 0 5px 0;
    color: #2c3e50;
}

.summary-info p {
    margin: 0;
    color: #7f8c8d;
    font-size: 14px;
}

/* Icons for placeholder */
.icon-user:before { content: "👤"; }
.icon-calendar:before { content: "📅"; }
.icon-user-md:before { content: "👨‍⚕️"; }
.icon-medkit:before { content: "💊"; }
.icon-activity:before { content: "📊"; }

/* Dashboard Content Layout */
.dashboard-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
}

.dashboard-card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    margin-bottom: 25px;
    overflow: hidden;
}

.card-header {
    padding: 15px 20px;
    border-bottom: 1px solid #eee;
    background-color: #fafafa;
}

.card-header h2 {
    margin: 0;
    font-size: 18px;
    color: #2c3e50;
}

.card-content {
    padding: 20px;
}

.card-footer {
    padding: 12px 20px;
    border-top: 1px solid #eee;
    text-align: center;
    background-color: #fafafa;
}

.view-all {
    color: #3498db;
    text-decoration: none;
    font-size: 14px;
    transition: color 0.2s;
}

.view-all:hover {
    color: #2980b9;
    text-decoration: underline;
}

/* Activity List */
.activity-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    padding: 12px 0;
    border-bottom: 1px solid #eee;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    color: white;
    flex-shrink: 0;
}

.activity-registration { background-color: #3498db; }
.activity-appointment { background-color: #2ecc71; }
.activity-payment { background-color: #f1c40f; }
.activity-medicine { background-color: #9b59b6; }

.activity-details {
    flex: 1;
}

.activity-description {
    display: block;
    font-size: 14px;
    color: #666;
}

.activity-time {
    display: block;
    font-size: 12px;
    color: #999;
    margin-top: 3px;
}

/* Schedule */
.schedule-item {
    display: flex;
    padding: 12px 0;
    border-bottom: 1px solid #eee;
}

.schedule-item:last-child {
    border-bottom: none;
}

.schedule-time {
    width: 60px;
    font-weight: bold;
    color: #333;
    flex-shrink: 0;
}

.schedule-details {
    flex: 1;
}

.schedule-title {
    font-weight: bold;
    color: #333;
}

.schedule-desc {
    font-size: 14px;
    color: #666;
    margin-top: 3px;
}

/* Quick Stats */
.quick-stats {
    padding: 5px 0;
}

.stat-item {
    margin-bottom: 20px;
}

.stat-item:last-child {
    margin-bottom: 0;
}

.stat-label {
    display: flex;
    justify-content: space-between;
    margin-bottom: 5px;
    color: #555;
    font-size: 14px;
}

.stat-value {
    font-weight: bold;
    color: #333;
}

.progress-bar {
    background-color: #ecf0f1;
    border-radius: 4px;
    height: 8px;
    overflow: hidden;
}

.progress {
    height: 100%;
    background-color: #e74c3c;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-content {
        grid-template-columns: 1fr;
    }
    
    .summary-boxes {
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    }
    
    .dashboard-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .header-right {
        margin-top: 15px;
        width: 100%;
        justify-content: space-between;
    }
}
</style>