document.addEventListener("DOMContentLoaded", function () {
  const askButton = document.getElementById("wpaipdf-ask-btn");

  if (!askButton) {
    return;
  }

  askButton.addEventListener("click", function () {
    const question = document.getElementById("wpaipdf-question").value.trim();
    const pdfPath = document.getElementById("wpaipdf-pdf-select").value;
    const responseBox = document.getElementById("wpaipdf-response");

    if (question === "") {
      responseBox.innerHTML = "Please enter a question.";
      return;
    }

    responseBox.innerHTML = "Thinking...";

    const formData = new FormData();

    formData.append("action", "wpaipdf_chat");
    formData.append("question", question);
    formData.append("pdf_path", pdfPath);

    fetch(ajaxurl, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((response) => {
        console.log("Full Response:", response);

        if (!response.success) {
          console.error(response.data);

          responseBox.innerHTML =
            "<pre>" + JSON.stringify(response.data, null, 2) + "</pre>";

          return;
        }

        responseBox.innerHTML = response.data.answer;
      })
      .catch((error) => {
        console.error(error);

        responseBox.innerHTML = "<strong>Request Failed</strong><br>" + error;
      });
  });
});
