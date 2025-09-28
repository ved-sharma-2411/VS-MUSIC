<!-- Loading/Waiting Popup -->
<div id="waitingPopup" class="waiting-popup-overlay" style="display: none;">
    <div class="waiting-popup-content">
        <div class="waiting-spinner">🎵</div>
        <h3>Loading Audio</h3>
        <p>This is a demonstration project using free hosting services. Audio streaming may experience delays due to
            server limitations. Thank you for your patience.</p>
        <div class="loading-dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>

<style>
    .waiting-popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 10000;
        backdrop-filter: blur(5px);
    }

    .waiting-popup-content {
        background: linear-gradient(135deg, #1e1e1e, #2a2a2a);
        padding: 30px;
        border-radius: 15px;
        text-align: center;
        color: white;
        max-width: 400px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .waiting-spinner {
        font-size: 60px;
        animation: spin 2s linear infinite, pulse 1.5s ease-in-out infinite alternate;
        margin-bottom: 20px;
        display: inline-block;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        100% {
            transform: scale(1.2);
        }
    }

    .waiting-popup-content h3 {
        margin: 0 0 15px 0;
        font-size: 24px;
        color: #1DB954;
    }

    .waiting-popup-content p {
        margin: 0 0 20px 0;
        font-size: 14px;
        line-height: 1.5;
        color: #ccc;
    }

    .loading-dots {
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .loading-dots span {
        width: 8px;
        height: 8px;
        background: #1DB954;
        border-radius: 50%;
        animation: bounce 1.4s ease-in-out infinite both;
    }

    .loading-dots span:nth-child(1) {
        animation-delay: -0.32s;
    }

    .loading-dots span:nth-child(2) {
        animation-delay: -0.16s;
    }

    @keyframes bounce {

        0%,
        80%,
        100% {
            transform: scale(0);
        }

        40% {
            transform: scale(1);
        }
    }
</style>

<script>
    function showWaitingPopup() {
        document.getElementById('waitingPopup').style.display = 'flex';
    }

    function hideWaitingPopup() {
        document.getElementById('waitingPopup').style.display = 'none';
    }

    // Auto-hide popup when audio starts playing
    document.addEventListener('DOMContentLoaded', function () {
        const audio = document.getElementById('nowPlayingBarContainer').querySelector('audio');
        if (audio) {
            audio.addEventListener('canplay', hideWaitingPopup);
            audio.addEventListener('playing', hideWaitingPopup);
            audio.addEventListener('loadstart', showWaitingPopup);
        }
    });
</script>