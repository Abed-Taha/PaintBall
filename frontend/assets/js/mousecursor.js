const mousePointer = document.getElementById("mouse-cursor");
document.querySelector("body").addEventListener("mousemove", (e) => {
  mousePointer.style.top = e.clientY + "px";
  mousePointer.style.left = e.clientX + "px";
});
