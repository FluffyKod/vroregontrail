
// Set the correct li in nav to be highlighted
function highlightLink(linkId) {
  // Get the root to all links
  navRoot = document.getElementById('navbar-nav');

  // Get all links
  var links = navRoot.children;

  // Loop through every link
  for (var i = 0; i < links.length; i++) {
    var link = links[i];

    // If the link is highlighted, dehighlight it
    if (link.classList.contains('active')) {
      link.classList.remove('active');
    }
  }

  // Highlight specified link
  document.getElementById(linkId).classList.add('active');
}

function showAnswerForm( formId ){
  answerDiv = document.getElementById(formId);

  // Check if display property is empty, if so set it a default of none
  // if (answerDiv.style.display != 'none' && answerDiv.style.display != 'block') {
  //   answerDiv.style.display = 'none';
  // }

  // Toggle visibility
  // answerDiv.style.display = (answerDiv.style.display == 'none') ? 'block' : 'none';
  answerDiv.style.opacity = (answerDiv.style.opacity == 0 ? 1 : 0);
  answerDiv.style.width = (answerDiv.style.width == 0 || answerDiv.style.width == '0px') ? '100%' : '0';
  answerDiv.style.height = (answerDiv.style.height == 0 || answerDiv.style.height == '0px') ? '100%' : '0';
}
