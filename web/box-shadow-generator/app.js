// Importing inputs, textarea, button and shadow monitor
const shadowArea = document.querySelector('.shadowShowcase');
const inputValues = document.querySelectorAll('input');
const generatedCode = document.querySelector('#generatedCode');
const copyCode = document.querySelector('#copyCode');

// This function will collects all the values in the imported input elements array like object
// and returns an object of that data
function valuesCollector() {
    let rightVal = inputValues[0].value;
    let downVal = inputValues[1].value;
    let blurVal = inputValues[2].value;
    let spreadVal = inputValues[3].value;
    let opacityVal = inputValues[4].value;
    let colorVal = inputValues[5].value;
    let insetVal = inputValues[6].checked;

    return {
        rightVal: rightVal,
        downVal: downVal,
        blurVal: blurVal,
        spreadVal: spreadVal,
        opacityVal: opacityVal,
        colorVal: colorVal,
        insetVal: insetVal
    }
}

// The shadow generator
function shadowGenerator() {
    let generatedValues = valuesCollector();
    let isInset = generatedValues.insetVal ? 'inset' : '';

    // These three lines of code will covert the color and opacity values 
    // into hexa decimal and combine them into one
    let opacityAdded = (Number(generatedValues.opacityVal)).toString(16);
    let colorValue = (generatedValues.colorVal).toString();
    let colorString = colorValue + opacityAdded;

    // This will returns a string that included the css code of the shadow
    let generatedShadow = generatedValues.rightVal + 'px ' +
                          generatedValues.downVal + 'px ' +
                          generatedValues.blurVal + 'px ' +
                          generatedValues.spreadVal + 'px ' +
                          colorString + ' ' +
                          isInset;
    shadowArea.style.boxShadow = generatedShadow;
    
    // This function set the textarea value to the css code
    generatedCodeHandler(generatedShadow);
}

function generatedCodeHandler(generatedShadowCode) {
    generatedCode.value = generatedShadowCode;
}

// This function will copy the generated css code into the clipboard
copyCode.addEventListener('click', () => {
    navigator.clipboard.writeText(generatedCode.value);
});

setInterval(shadowGenerator, 0);