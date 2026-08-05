document.addEventListener("DOMContentLoaded", function () {
  const toggleButton = document.getElementById("wpaipdf-chat-toggle");
  const chatWindow = document.getElementById("wpaipdf-chat-window");
  const askButton = document.getElementById("wpaipdf-ask-btn");

  if (toggleButton && chatWindow) {
    chatWindow.style.display = "none";

    toggleButton.addEventListener("click", function () {
      if (chatWindow.style.display === "none") {
        chatWindow.style.display = "flex";
      } else {
        chatWindow.style.display = "none";
      }
    });
  }

  if (!askButton) {
    return;
  }

  askButton.addEventListener("click", function () {
    const question = document.getElementById("wpaipdf-question").value.trim();

    const responseBox = document.getElementById("wpaipdf-response");

    if (question === "") {
      alert("Please enter your question.");
      return;
    }

    askButton.disabled = true;

    const formData = new FormData();

    formData.append("action", "wpaipdf_chat");
    formData.append("question", question);

    fetch(wpaipdf.ajax_url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((response) => {
        askButton.disabled = false;

        if (!response.success) {
          responseBox.innerHTML =
            "<div style='color:red'>" + response.data + "</div>";

          return;
        }

        responseBox.innerHTML = response.data.answer;

        document.getElementById("wpaipdf-question").value = "";

        responseBox.scrollTop = responseBox.scrollHeight;
      })
      .catch((error) => {
        askButton.disabled = false;

        console.error(error);

        responseBox.innerHTML = "<div style='color:red'>Request Failed.</div>";
      });
  });
});
