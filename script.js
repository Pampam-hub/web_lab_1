let form = document.querySelector('form');
let R = form.elements.R;
let rError = document.querySelector('span.r-error');
let X = form.elements.X;
let xError = document.querySelector('span.x-error');
let Y = form.elements.Y;
let yError = document.querySelector('span.y-error');

const numberRegExp = /^(-?\d\.\d+|-?\d|-?\de-?\d+)$/;

function showMissingError(param, paramError) {
    paramError.textContent = `Задайте ${param}, пожалуйста`;
    paramError.className = 'error';
}

function showNumberFormatError(param, paramError) {
    paramError.textContent = `Представьте ${param}, как число в привычном виде`;
    paramError.className = 'error';
}

function showArithmeticError(param, paramError) {
    paramError.textContent = `Обратите внимание на пределы ${param}`;
    paramError.className = 'error';
}

form.addEventListener('submit', event => { 
    missingR = R.validity.valueMissing;
    missingX = X.validity.valueMissing;
    numberFormatX = !numberRegExp.test(X.value);
    arithmeticX = parseFloat(X.value) <= -5 || parseFloat(X.value) >= 3;
    missingY = Y.validity.valueMissing;
    
    if (missingX || missingY || missingR || numberFormatX ||  arithmeticX) {
        event.preventDefault();
        rError.textContent = '';
        rError.className = 'not error';
        yError.textContent = '';
        yError.className = 'not error';
        xError.textContent = '';
        xError.className = 'not error';  

        if(missingR) {
            showMissingError('R', rError);
        } else if (missingX) {
            showMissingError('X', xError);
        } else if (numberFormatX) {
            showNumberFormatError('X', xError);
        } else if (arithmeticX) {
            showArithmeticError('X', xError);
        } else {
            showMissingError('Y', yError);
        }
    } 
});