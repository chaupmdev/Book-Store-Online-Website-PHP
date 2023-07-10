imageInput.addEventListener('change', () => {
  const file = imageInput.files[0];
  const reader = new FileReader();

  reader.addEventListener('load', () => {
    previewImage.src = reader.result;
  }, false);

  if (file) {
      reader.readAsDataURL(file);
      image.value = file.name;
  }
});