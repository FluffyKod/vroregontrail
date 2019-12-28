function checkForm(form, textElement, limit){
  let formText = form.value;
  let trimmedText = formText.substring(0, limit);
  form.value = trimmedText;

  textElement.innerText = limit - trimmedText.length;
}
