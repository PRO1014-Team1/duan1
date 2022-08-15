window.addEventListener("load", () => {
  const audioControls = document.querySelector(".audio-wrapper");
  const playBtn = document.querySelector(".utils-button");
  const volumeBtn = document.querySelector(".volume-toggle-btn");
  const audioPlayerContainer = document.querySelector(".audio-controls");

  const audio = document.querySelector(".audio");

  const audioPlayBtn = document.querySelector(".audio-toggle-btn");
  const currentTimeContainer = document.getElementById("current-time");
  const seekSlider = document.getElementById("seek-slider");
  const durationContainer = document.getElementById("duration");

  const volumeSlider = document.getElementById("volume-slider");
  const muteBtn = document.querySelector(".mute-toggle-btn");
  let muteState = "unmute";

  let audioPlayState = false;

  let rAF = null;

  // show audio controls
  document.querySelector(".listen").addEventListener("click", () => {
    audioControls.classList.toggle("hidden");
  });

  // play audio
  playBtn.addEventListener("click", () => {
    audioToggle();
  });

  // open volume slider
  volumeBtn.addEventListener("click", () => {
    volumeToggle();
  });

  // mute audio
  muteBtn.addEventListener("click", () => {
    muteToggle();
  });

  const whilePlaying = () => {
    seekSlider.value = Math.floor(audio.currentTime);
    currentTimeContainer.textContent = calculateTime(seekSlider.value);
    audioPlayerContainer.style.setProperty(
      "--seek-before-width",
      `${(seekSlider.value / seekSlider.max) * 100}%`
    );
    rAF = requestAnimationFrame(whilePlaying);
  };

  function audioToggle() {
    audioPlayBtn.classList.toggle("fa-play");
    audioPlayBtn.classList.toggle("fa-pause");
    if (!audioPlayState) {
      audio.play();
      audioPlayState = true;
      requestAnimationFrame(whilePlaying);
    } else {
      audio.pause();
      audioPlayState = false;
      cancelAnimationFrame(rAF);
    }
  }

  seekSlider.addEventListener("input", () => {
    currentTimeContainer.textContent = calculateTime(seekSlider.value);
    if (!audio.paused) {
      cancelAnimationFrame(rAF);
    }
  });

  seekSlider.addEventListener("change", () => {
    audio.currentTime = seekSlider.value;
    if (!audio.paused) {
      requestAnimationFrame(whilePlaying);
    }
  });

  audio.addEventListener("timeupdate", () => {
    seekSlider.value = Math.floor(audio.currentTime);
  });

  const calculateTime = (secs) => {
    const minutes = Math.floor(secs / 60);
    const seconds = Math.floor(secs % 60);
    const returnedSeconds = seconds < 10 ? `0${seconds}` : `${seconds}`;
    return `${minutes}:${returnedSeconds}`;
  };

  const displayDuration = () => {
    durationContainer.textContent = calculateTime(audio.duration);
  };

  if (audio.readyState > 0) {
    displayDuration();
  } else {
    audio.addEventListener("loadedmetadata", () => {
      displayDuration();
    });
  }

  const setSliderMax = () => {
    seekSlider.max = Math.floor(audio.duration);
  };

  if (audio.readyState > 0) {
    displayDuration();
    setSliderMax();
  } else {
    audio.addEventListener("loadedmetadata", () => {
      displayDuration();
      setSliderMax();
    });
  }

  let volumeMinimized = volumeSlider.getAttribute("data-minimize");

  function volumeToggle() {
    if (volumeMinimized === "false") {
      volumeSlider.setAttribute("data-minimize", true);
      volumeSlider.setAttribute("type", "hidden");
    } else {
      volumeSlider.setAttribute("type", "range");
      volumeSlider.setAttribute("data-minimize", false);
    }

    volumeMinimized = volumeSlider.getAttribute("data-minimize");
  }

  volumeSlider.addEventListener("input", (e) => {
    const value = e.target.value;

    audio.volume = value / 100;
  });

  function muteToggle() {
    muteBtn.classList.toggle("fa-volume-xmark");
    muteBtn.classList.toggle("fa-volume-high");

    if (muteState === "unmute") {
      audio.muted = true;
      muteState = "mute";
    } else {
      audio.muted = false;
      muteState = "unmute";
    }
  }
});
