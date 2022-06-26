function onSubmit(token) {
    document.getElementById("recaptcha-form").submit();
}

function validate(event) {
    event.preventDefault();
    if (!document.getElementById('recaptcha-form').value) {
        alert("You must add text to the required field");
    } else {
        grecaptcha.execute();
    }
}




var onSubmit = function (token) {
    console.log('Message envoyé!');
};

$recaptcha_public_key = '6LfN8pIgAAAAAJza8SesGMU3l7GRByC3Vm0WOxzs';

const onloadCallback = function () {
    grecaptcha.render('submit', {
        'sitekey': $recaptcha_public_key,
        'callback': onSubmit
    });
    grecaptcha.reset();
};



function onload() {
    var element = document.getElementById('submit');
    element.onclick = validate;
}

if (typeof grecaptcha === 'undefined') {
    grecaptcha = {};
}
grecaptcha.ready = function (cb) {
    if (typeof grecaptcha === 'undefined') {
        // window.__grecaptcha_cfg is a global variable that stores reCAPTCHA's
        // configuration. By default, any functions listed in its 'fns' property
        // are automatically executed when reCAPTCHA loads.
        const c = '___grecaptcha_cfg';
        window[c] = window[c] || {};
        (window[c]['fns'] = window[c]['fns'] || []).push(cb);
    } else {
        cb();
    }
}

// Usage
grecaptcha.ready(function () {
    grecaptcha.render("container", {
        sitekey: "ABC-123"
    });
});