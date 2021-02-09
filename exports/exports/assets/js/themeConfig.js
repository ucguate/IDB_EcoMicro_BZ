const activeCU = "SFXCU"  

var logo1Src = null, CU_name = null, CU_shortName = null, CU_sector = null, pColor = null, sColor = null;

switch (activeCU) {
    case "LICU":
        logo1Src = "/logos/LICU_logo.png",
        CU_name = "La Inmaculada Credit Union",
        CU_shortName = "LICU",
        CU_sector = "Livestock",
        pColor = "#EB670F",
        sColor = "#F49C00";
        break;

    case "TTCU":
        logo1Src = "/logos/TTCU_logo.png",
        CU_name = "Toledo Teachers Credit Union",
        CU_shortName = "TTCU"
        CU_sector = "Agriculture & Fisheries";
        pColor = "#5575cc",
        sColor = "#5575cc";
        break;

    case "SFXCU":
        logo1Src = "/logos/SFXCU_logo.png",
        CU_name = "St. Francis Xavier Credit Union",
        CU_shortName = "SFXCU"
        CU_sector = "Agriculture & Fisheries",
        pColor = "#2e9669",
        sColor = "#DD9932";
        break;

    default:
        break;
}

function applyThemeConfig(){

    // apply logo src to class
    $(".logo1Placeholder").attr("src",logo1Src);

    // apply bg color to class
    $(".bg-gradient-primary").css("background-color", pColor);

    // setting CU name inside placeholders that match class 
    $(".CU_name").text(CU_name);



}