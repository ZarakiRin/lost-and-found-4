document.getElementById('resetForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const button = document.getElementById('submitBtn');
  button.classList.add('loading');

  // Simulate async action
  setTimeout(() => {
    button.classList.remove('loading');
    // You can add response message here
  }, 3000); // Replace with actual async logic
});


const form = document.getElementById('resetForm');
    const responseBox = document.getElementById('responseMessage');
    const spinner = document.getElementById('spinner');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', async function (e) {
      e.preventDefault();
      spinner.style.display = 'inline-block';
      submitBtn.disabled = true;
      responseBox.innerHTML = '';

      const formData = new FormData(form);
      const response = await fetch('sendpass.php', {
        method: 'POST',
        body: formData
      });

      const data = await response.json();
      spinner.style.display = 'none';
      submitBtn.disabled = false;

      if (data.success) {
        responseBox.innerHTML = `<div class="message-box">${data.message}</div>`;
        form.reset();
      } else {
        responseBox.innerHTML = `<div class="error-box">${data.message}</div>`;
      }
    });