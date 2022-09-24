function resetCookie() {
    let cookieMessage = document.querySelector('#cookie-message');
    cookieMessage.textContent = '';
    cookieMessage.id = 'not cookie';
}

function acceptCookie() {
    $.ajax({
        type: 'GET',
        url: './main.php',
        data: {'cookie': true},
        success: function(data) {
            updateTable(data);
        },
        error: function(data) {
            alert(data);
        }
    });

    resetCookie();
}

function denyCookie() {
    resetCookie();
}

function init() {

    if ( !document.cookie.split(';').some(c => {
        return c.trim().startsWith('informed' + '=');})) {
        const cookieMessage = `
        <p>Если Вы не хотите потерять свою таблицу в ближайшее время - примите cookie</p><br>
        <a id='i-agree' onClick='acceptCookie()'>Хочу cookie 🍪</a>
        <a id='i-not-agree' onClick='denyCookie()'>Отстаньте со своими cookie 😑</a>
        `;
        cookieMessage.id = 'not cookie';
        $('#cookie-message').html(cookieMessage); 
    } else {
        resetCookie();
    }

    $.ajax({
        type: 'GET',
        url: './main.php',
        data: {'table': true},
        success: function(data) {
            updateTable(data);
        },
        error: function(data) {
            alert(data);
        }
    });
}