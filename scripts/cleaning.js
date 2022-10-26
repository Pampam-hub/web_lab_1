function cleanTable() {
    const empty_table = `
    <thead>
        <tr>
            <th>R</th>
            <th>X</th>
            <th>Y</th>
            <th>Результат</th>
            <th>Время запроса</th>
            <th>Время исполнения, мс</th>
        </tr>
    </thead>`;
    $('table.info').html(empty_table);
    
    $.ajax({
        type: 'GET',
        url: './main.php',
        data: {'unset': true},
        success: function(data) {
            updateTable(data);
        },
        error: function(data) {
            alert(data);
        }
    });
}