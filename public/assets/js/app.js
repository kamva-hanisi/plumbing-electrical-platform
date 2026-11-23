"use strict";

document.addEventListener("DOMContentLoaded", () => {
  const testButton = document.getElementById("testButton");
  const testMessage = document.getElementById("testMessage");

  if (!testButton || !testMessage) {
    return;
  }

  testButton.addEventListener("click", () => {
    testMessage.textContent =
      "Success! Vanilla JavaScript is working correctly.";

    testMessage.style.color = "#16a34a";

    testButton.textContent = "JavaScript Working!";
  });
});
