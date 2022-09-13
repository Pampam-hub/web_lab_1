function cleanTable() {
    const empty_table = `
    <thead>
        <tr>
            <th>R</th>
            <th>X</th>
            <th>Y</th>
            <th>Результат</th>
            <th>Время запроса</th>
            <th>Время исполнения</th>
        </tr>
    </thead>`;
    $('table.info').html(empty_table);
    window.localStorage.removeItem('table_data');
}