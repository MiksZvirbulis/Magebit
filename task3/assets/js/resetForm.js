function resetForm() {
        const formElements = document.getElementById("form");
        for (i = 0; i < formElements.length; i++) {
            field_type = formElements[i].type.toLowerCase();
            switch (field_type) {
            case "text":
            case "textarea":
            case "hidden":
                formElements[i].value = "";
                break;
            case "select-multi":
            case "select-one":
                formElements[i].selectedIndex = 0;
                break;
            default:
                break;
            }
        }
    }