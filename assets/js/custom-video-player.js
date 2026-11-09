class CustomVideoPlayer {
  constructor(container, videoUrl) {
    this.container = container;
    this.videoUrl = videoUrl;
    this.videoId = this.extractVideoId(videoUrl);
    this.isPlaying = false;
    this.volume = 1;
    this.currentTime = 0;
    this.duration = 0;
    this.player = null;
    this.updateInterval = null;

    this.init();
  }

  extractVideoId(url) {
    const regex =
      /(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\n?#]+)/;
    const match = url.match(regex);
    return match ? match[1] : null;
  }

  init() {
    this.createPlayer();
    this.bindEvents();
    this.loadYouTubeAPI();
  }

  loadYouTubeAPI() {
    // Load YouTube IFrame API
    if (!window.YT) {
      const tag = document.createElement("script");
      tag.src = "https://www.youtube.com/iframe_api";
      const firstScriptTag = document.getElementsByTagName("script")[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      window.onYouTubeIframeAPIReady = () => {
        this.createYouTubePlayer();
      };
    } else {
      this.createYouTubePlayer();
    }
  }

  createYouTubePlayer() {
    this.player = new YT.Player("youtube-iframe", {
      height: "100%",
      width: "100%",
      videoId: this.videoId,
      playerVars: {
        autoplay: 1,
        mute: 0,
        controls: 0,
        modestbranding: 1,
        rel: 0,
        showinfo: 0,
        iv_load_policy: 3,
        vq: "hd2160", // 4K quality
        origin: window.location.origin,
        enablejsapi: 1,
      },
      events: {
        onReady: (event) => this.onPlayerReady(event),
        onStateChange: (event) => this.onPlayerStateChange(event),
        onError: (event) => this.onPlayerError(event),
      },
    });
  }

  onPlayerReady(event) {
    this.duration = event.target.getDuration();
    this.elements.totalTime.textContent = this.formatTime(this.duration);
    this.startProgressUpdate();
    this.elements.videoPlaceholder.style.display = "none";
    this.elements.youtubeIframe.style.display = "block";
    this.isPlaying = true;
    this.updatePlayPauseButton();
  }

  onPlayerStateChange(event) {
    switch (event.data) {
      case YT.PlayerState.PLAYING:
        this.isPlaying = true;
        this.updatePlayPauseButton();
        break;
      case YT.PlayerState.PAUSED:
        this.isPlaying = false;
        this.updatePlayPauseButton();
        break;
      case YT.PlayerState.ENDED:
        this.isPlaying = false;
        this.updatePlayPauseButton();
        break;
    }
  }

  onPlayerError(event) {
    console.error("YouTube Player Error:", event.data);
    // Fallback to placeholder
    this.elements.youtubeIframe.style.display = "none";
    this.elements.videoPlaceholder.style.display = "flex";
    this.elements.videoPlaceholder.innerHTML = `
            <div class="error-message">
                <h3>Không thể tải video</h3>
                <p>Vui lòng thử lại sau</p>
            </div>
        `;
  }

  startProgressUpdate() {
    this.updateInterval = setInterval(() => {
      if (this.player && this.isPlaying) {
        this.currentTime = this.player.getCurrentTime();
        this.updateProgress();
      }
    }, 1000);
  }

  stopProgressUpdate() {
    if (this.updateInterval) {
      clearInterval(this.updateInterval);
      this.updateInterval = null;
    }
  }

  createPlayer() {
    this.container.innerHTML = `
            <div class="custom-video-player">
                <div class="video-container">
                    <div class="video-placeholder" id="video-placeholder">
                        <div class="play-button" id="play-button">
                            <svg width="60" height="60" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                        <div class="video-info">
                            <h3>GOMIE - Gốm sứ Bát Tràng</h3>
                            <p>Video chất lượng 4K</p>
                        </div>
                    </div>
                    <div id="youtube-iframe"></div>
                </div>
                
                <div class="video-controls">
                    <div class="control-group">
                        <button class="control-btn play-pause-btn" id="play-pause-btn" title="Phát/Dừng">
                            <svg class="play-icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                            <svg class="pause-icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" style="display: none;">
                                <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                            </svg>
                        </button>
                        
                        <div class="volume-control">
                            <button class="control-btn volume-btn" id="volume-btn" title="Âm lượng">
                                <svg class="volume-high" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/>
                                </svg>
                                <svg class="volume-mute" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" style="display: none;">
                                    <path d="M16.5 12c0-1.77-1.02-3.29-2.5-4.03v2.21l2.45 2.45c.03-.2.05-.41.05-.63zm2.5 0c0 .94-.2 1.82-.54 2.64l1.51 1.51C20.63 14.91 21 13.5 21 12c0-4.28-2.99-7.86-7-8.77v2.06c2.89.86 5 3.54 5 6.71zM4.27 3L3 4.27 7.73 9H3v6h4l5 5v-6.73l4.25 4.25c-.67.52-1.42.93-2.25 1.18v2.06c1.38-.31 2.63-.95 3.69-1.81L19.73 21 21 19.73l-9-9L4.27 3zM12 4L9.91 6.09 12 8.18V4z"/>
                                </svg>
                            </button>
                            <div class="volume-slider-container">
                                <input type="range" class="volume-slider" id="volume-slider" min="0" max="100" value="100" step="1">
                            </div>
                        </div>
                    </div>
                    
                    <div class="progress-container">
                        <div class="progress-bar" id="progress-bar">
                            <div class="progress-fill" id="progress-fill"></div>
                        </div>
                        <div class="time-display">
                            <span id="current-time">0:00</span>
                            <span>/</span>
                            <span id="total-time">0:00</span>
                        </div>
                    </div>
                </div>
            </div>
        `;

    // Cache DOM elements
    this.elements = {
      videoPlaceholder: this.container.querySelector("#video-placeholder"),
      youtubeIframe: this.container.querySelector("#youtube-iframe"),
      playButton: this.container.querySelector("#play-button"),
      playPauseBtn: this.container.querySelector("#play-pause-btn"),
      volumeBtn: this.container.querySelector("#volume-btn"),
      volumeSlider: this.container.querySelector("#volume-slider"),
      progressBar: this.container.querySelector("#progress-bar"),
      progressFill: this.container.querySelector("#progress-fill"),
      currentTime: this.container.querySelector("#current-time"),
      totalTime: this.container.querySelector("#total-time"),
    };
  }

  bindEvents() {
    // Play button events
    this.elements.playButton.addEventListener("click", () => this.playVideo());
    this.elements.playPauseBtn.addEventListener("click", () =>
      this.togglePlayPause()
    );

    // Volume control events
    this.elements.volumeBtn.addEventListener("click", () => this.toggleMute());
    this.elements.volumeSlider.addEventListener("input", (e) =>
      this.setVolume(e.target.value / 100)
    );

    // Progress bar events
    this.elements.progressBar.addEventListener("click", (e) => this.seekTo(e));

    // Keyboard shortcuts
    document.addEventListener("keydown", (e) => this.handleKeyboard(e));

    // Mouse events for volume slider
    this.container
      .querySelector(".volume-control")
      .addEventListener("mouseenter", () => {
        this.container.querySelector(".volume-slider-container").style.opacity =
          "1";
      });

    this.container
      .querySelector(".volume-control")
      .addEventListener("mouseleave", () => {
        this.container.querySelector(".volume-slider-container").style.opacity =
          "0";
      });
  }

  playVideo() {
    if (this.player) {
      this.player.playVideo();
    }
    this.elements.videoPlaceholder.style.display = "none";
    this.elements.youtubeIframe.style.display = "block";
  }

  togglePlayPause() {
    if (this.player) {
      if (this.isPlaying) {
        this.player.pauseVideo();
      } else {
        this.player.playVideo();
      }
    }
  }

  updatePlayPauseButton() {
    const playIcon = this.elements.playPauseBtn.querySelector(".play-icon");
    const pauseIcon = this.elements.playPauseBtn.querySelector(".pause-icon");

    if (this.isPlaying) {
      playIcon.style.display = "none";
      pauseIcon.style.display = "block";
    } else {
      playIcon.style.display = "block";
      pauseIcon.style.display = "none";
    }
  }

  toggleMute() {
    if (this.player) {
      if (this.volume > 0) {
        this.player.mute();
        this.volume = 0;
      } else {
        this.player.unMute();
        this.volume = 1;
      }
      this.elements.volumeSlider.value = this.volume * 100;
      this.updateVolumeButton();
    }
  }

  setVolume(value) {
    if (this.player) {
      this.volume = value;
      this.player.setVolume(value * 100);
      this.updateVolumeButton();
      this.elements.volumeSlider.value = value * 100;
    }
  }

  updateVolumeButton() {
    const volumeHigh = this.elements.volumeBtn.querySelector(".volume-high");
    const volumeMute = this.elements.volumeBtn.querySelector(".volume-mute");

    if (this.volume > 0) {
      volumeHigh.style.display = "block";
      volumeMute.style.display = "none";
    } else {
      volumeHigh.style.display = "none";
      volumeMute.style.display = "block";
    }
  }

  seekTo(event) {
    if (this.player && this.duration > 0) {
      const rect = this.elements.progressBar.getBoundingClientRect();
      const clickX = event.clientX - rect.left;
      const percentage = clickX / rect.width;
      const seekTime = percentage * this.duration;

      this.player.seekTo(seekTime, true);
    }
  }

  updateProgress() {
    if (this.duration > 0) {
      const percentage = (this.currentTime / this.duration) * 100;
      this.elements.progressFill.style.width = percentage + "%";

      // Update time display
      this.elements.currentTime.textContent = this.formatTime(this.currentTime);
    }
  }

  formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const remainingSeconds = Math.floor(seconds % 60);
    return `${minutes}:${remainingSeconds.toString().padStart(2, "0")}`;
  }

  handleKeyboard(event) {
    switch (event.code) {
      case "Space":
        event.preventDefault();
        this.togglePlayPause();
        break;
      case "ArrowLeft":
        event.preventDefault();
        this.seekBackward();
        break;
      case "ArrowRight":
        event.preventDefault();
        this.seekForward();
        break;
      case "ArrowUp":
        event.preventDefault();
        this.increaseVolume();
        break;
      case "ArrowDown":
        event.preventDefault();
        this.decreaseVolume();
        break;
    }
  }

  seekBackward() {
    if (this.player) {
      const newTime = Math.max(0, this.currentTime - 10);
      this.player.seekTo(newTime, true);
    }
  }

  seekForward() {
    if (this.player) {
      const newTime = Math.min(this.duration, this.currentTime + 10);
      this.player.seekTo(newTime, true);
    }
  }

  increaseVolume() {
    this.setVolume(Math.min(1, this.volume + 0.1));
  }

  decreaseVolume() {
    this.setVolume(Math.max(0, this.volume - 0.1));
  }

  destroy() {
    this.stopProgressUpdate();
    if (this.player) {
      this.player.destroy();
    }
  }
}

// Initialize video player when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
  const videoContainer = document.querySelector(".custom-video-container");
  if (videoContainer) {
    const videoUrl = "https://www.youtube.com/watch?v=XWlJn5T81CU";
    window.customVideoPlayer = new CustomVideoPlayer(videoContainer, videoUrl);
  }
});
