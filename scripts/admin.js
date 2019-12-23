
function highlightLink(linkId) {
  // Remove active class from all
  navRoot = document.getElementById('navbar-nav');

  var links = navRoot.children;
  for (var i = 0; i < links.length; i++) {
    var link = links[i];
    if (link.classList.contains('active')) {
      link.classList.remove('active');
    }
  }

  // Apply class to correct link
  document.getElementById(linkId).classList.add('active');
}
