// inputs

const inputs = document.querySelectorAll(".input input"); // return collection of elements .
const inputTypeFixedLabel = ["datetime-local", "file"];
[...inputs].forEach((input) => {
  checkInput(input);
  if (inputTypeFixedLabel.includes(input.type))
    input.classList.add("input-has-value");
  input.addEventListener("blur", (e) => {
    checkInput(e.target);
  });
});

function checkInput(input) {
  if (input.value.length > 0) {
    input.classList.add("input-has-value");
  } else {
    if (!inputTypeFixedLabel.includes(input.type))
      input.classList.remove("input-has-value");
  }
}

// humburger menu toggle
const hum = document.querySelector(".hum");
const navLink = document.querySelector(".nav-link");

hum.addEventListener("click", () => {
  navLink.classList.add("nav-link-open");
  hum.classList.add("hum-open");
  hum.classList.add("animation-fade-out");

  // close the menu when clicking outside
  document.body.addEventListener("click", (e) => {
    if (!navLink.contains(e.target) && !hum.contains(e.target)) {
      navLink.classList.remove("nav-link-open");
      hum.classList.remove("hum-open");
      hum.classList.remove("animation-fade-out");
    }
  });
});

// scroll
document.querySelectorAll(".events-scroll").forEach((container) => {
  let speed = parseFloat(container.dataset.speed) || 1; // get the speed from attribut data-speed="nb"
  let isHovered = false;

  // Duplicate items for infinite loop
  container.innerHTML += container.innerHTML;

  // pause and resume the scroll animation
  [...container.children].forEach((item) => {
    item.addEventListener("mouseenter", () => (isHovered = true));
    item.addEventListener("mouseleave", () => (isHovered = false));
  });

  function loop() {
    if (!isHovered) {
      container.scrollLeft += speed;

      // Reset when half is passed
      if (container.scrollLeft >= container.scrollWidth / 2) {
        container.scrollLeft = 0;
      }
    }
    requestAnimationFrame(loop); // infinite loop instead of setInterval Note: best Practice for animation
  }
  loop();
});

// location navigate roirters players
const roirter = document
  .querySelectorAll(".roirters-container .item")
  .forEach((item) => {
    item.addEventListener("click", () => {
      window.location.href = "/roirters/" + item.dataset.id;
    });
  });

//password
const pass = document.querySelectorAll(".show-password");
pass.forEach((p) => {
  p?.addEventListener("click", (e) => {
    togglePaswordView(e.target);
  });
});

function togglePaswordView(icon) {
  const input = icon.previousElementSibling.previousElementSibling;
  const path = "/frontend/assets/imgs/";
  if (input.dataset.type == "hide") {
    input.dataset.type = "show";
    icon.src = path + "eye-closed.png";
    input.type = "text";
  } else {
    icon.src = path + "eye-open.png";
    input.dataset.type = "hide";
    input.type = "password";
  }
}
// alert fade-out
const alertMessage = document.getElementById("alert");
setTimeout(() => alertMessage?.classList.add("alert-fade-out"), 3000);

// toggle password section
const togglePasswordBtn = document.getElementById("toggle-password-btn");
const passwordSection = document.getElementById("password-section");

togglePasswordBtn?.addEventListener("click", () => {
  togglePasswordShow();
});

function togglePasswordShow() {
  const img = document.createElement("img");
  img.src = "/frontend/assets/imgs/image.png";
  if (
    passwordSection.style.display === "none" ||
    passwordSection.style.display === ""
  ) {
    passwordSection.style.display = "block";
    togglePasswordBtn.textContent = "Cancel Password Change";
  } else {
    passwordSection.style.display = "none";
    togglePasswordBtn.textContent = "Change Password";
    // Clear inputs when hiding
    document.querySelectorAll("#password-section input").forEach((input) => {
      input.value = "";
      checkInput(input);
    });
  }

  togglePasswordBtn.appendChild(img);
}

function showPasswordSection() {
  console.log("showPasswordSection");
  passwordSection.style.display = "block";
  togglePasswordBtn.textContent = "Cancel Password Change";
}


//// ------------- for Modal -----------------------
const modal = document.getElementById("registerModal");
const openBtn = document.querySelectorAll(".modal");
const cancelBtn = document.querySelectorAll(".cancelBtn");


// Open modal
openBtn.forEach(e => e.addEventListener("click", function () {
    modal.style.display = "flex";
}));

// Cancel
cancelBtn.forEach(e => e.addEventListener("click", function () {
    modal.style.display = "none";
}));


