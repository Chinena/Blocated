///// EJEMPLO para tabla 1

const data = [
    { chip: 'a', fRecarga: 'fecha', vencimiento: 'fecha', monto: 'dinero' },
    { chip: 'b', fRecarga: 'fecha', vencimiento: 'fecha', monto: 'dinero' },
    { chip: 'c', fRecarga: 'fecha', vencimiento: 'fecha', monto: 'dinero' },
    { chip: 'd', fRecarga: 'fecha', vencimiento: 'fecha', monto: 'dinero' }
];

let tableBody = document.getElementById('tbody');

for (let i = 0; i < data.length; i++) {
    let chip = `<td>${data[i].chip}</td>`;
    let fRecarga = `<td>${data[i].fRecarga}</td>`;
    let vencimiento = `<td>${data[i].vencimiento}</td>`;
    let monto = `<td>$ ${data[i].monto}</td>`;

    tableBody.innerHTML += `<tr>${chip + fRecarga + vencimiento + monto}</tr>`;
}

//Nota: Puede ser posible que posteriormente se añada un EventListener

/*
<?php foreach ($datosDeLaBase as $dato): ?>
            <tr>
                <td><?php echo $dato['chip']; ?></td>
                <td><?php echo $dato['fRecarga']; ?></td>
                <td><?php echo $dato['vencimiento']; ?></td>
                <td>$ <?php echo $dato['monto']; ?></td>
            </tr>
        <?php endforeach; ?>
*/