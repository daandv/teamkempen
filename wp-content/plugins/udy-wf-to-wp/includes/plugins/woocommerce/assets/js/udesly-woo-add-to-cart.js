const cScript = document.currentScript;
const parent = cScript.closest('div');
const classConfigScript = parent.querySelector('script[data-type="add-to-cart-classes"]');
const classConfig = classConfigScript && JSON.parse(classConfigScript.innerHTML) || {form: '', input: '', option: '', labelQuantity: '', labelOption: '', button: ''};
const form = parent.querySelector('form');

if (form) {
    classConfig.form && form.classList.add(...classConfig.form.split(' '));
    const quantityNumber = form.querySelector('input[type="number"]');
    if(quantityNumber) {
        classConfig.input && quantityNumber.setAttribute('class', classConfig.input);
        const id = quantityNumber.id;
        const label = form.querySelector(`label[for="${id}"]`);
        label.setAttribute('class', classConfig.labelQuantity);
    }
    const optionSelect = form.querySelector('select');
    if (optionSelect) {
        classConfig.option && optionSelect.setAttribute('class', classConfig.option);
        const id = optionSelect.id;
        const label2 = form.querySelector(`label[for="${id}"]`);
        label2.setAttribute('class', classConfig.labelOption);
    }
    const button = form.querySelector('button[type="submit"]');
    if(button) {
        classConfig.button && button.classList.add(...classConfig.button.split(' '));
        classConfig.button && button.classList.remove('button');
    }
}
