/*
Write story form funtions
*/
function clearText() {
  if (document.getElementByClassName("jodit_wysiwyg").value = "It is a blank slate, be creative..") {
    document.getElementById("storyContent").value = "";
  }
}

function checkForMinlength(story, minlength) {
    return story.length >= minlength;

}
