function checkAll(e) {
    const checkboxes = document.getElementsByClassName('emailCheckbox');
    for (let i = 0, l = checkboxes.length; i < l; i++) {
      checkboxes[i].checked = e.checked;
    }
}