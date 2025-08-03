te comparto la estructura la respuesta del backend al presionar editar

Pasa que quiero igual el funcionamiento de rol.js pero en vue 

para tener elementos de esta manera
```html
<tr>
    <td class="font-weight-bold color-rol" colspan="5">
        <strong>CONFIGURACIÓN</strong>
    </td>
</tr>
    <tr data-menu="configuracion-empresa">
        <td>Empresa</td>
        <td class="text-center"><input type="checkbox" name="view"></td>
        <td class="text-center"><input type="checkbox" name="new"></td>
        <td class="text-center"><input type="checkbox" name="edit"></td>
    </tr>
    <tr data-menu="configuracion-area">
        <td>Areas</td>
        <td class="text-center"><input type="checkbox" name="view"></td>
        <td class="text-center"><input type="checkbox" name="new"></td>
        <td class="text-center"><input type="checkbox" name="edit"></td>
        <td class="text-center"><input type="checkbox" name="delete"></td>
    </tr>



    
    <tr>
        <td class="font-weight-bold color-rol" colspan="5" ><strong> OPERACIÓN
            </strong></td>
    </tr>

    <tr data-menu="operacion-nueva_incidencia">
        <td>Nueva Incidencia</td>
        <td class="text-center"><input type="checkbox" name="view"></td>
        <td class="text-center"><input type="checkbox" name="new"></td>
        <td class="text-center"> </td>
        <td class="text-center"></td>
    </tr>

    <tr data-menu="operacion-incidencias">
        <td>Incidencias</td>
        <td class="text-center"><input type="checkbox" name="view"></td>
        <td class="text-center"></td>
        <td class="text-center"><input type="checkbox" name="edit"></td>
        <td class="text-center"><input type="checkbox" name="delete"></td>
    </tr>


```
```json
[
  {
    "id": 1,
    "name": "testing",
    "fl_no_view_dashboard": "0",
    "created_at": "2025-07-28T15:00:15.000000Z",
    "updated_at": "2025-07-29T17:26:59.000000Z",
    "role_details": [
      {
        "id": 826,
        "id_role": 1,
        "view": "1",
        "new": "0",
        "edit": "0",
        "delete": "1",
        "created_at": "2025-07-29T17:16:53.000000Z",
        "updated_at": "2025-07-29T17:16:53.000000Z",
        "menu": "configuracion-empresa"
      },
      {
        "id": 825,
        "id_role": 1,
        "view": "0",
        "new": "1",
        "edit": "1",
        "delete": "1",
        "created_at": "2025-07-29T17:16:53.000000Z",
        "updated_at": "2025-07-29T17:16:53.000000Z",
        "menu": "dashboard-general"
      },
      {
        "id": 824,
        "id_role": 1,
        "view": "0",
        "new": "1",
        "edit": "1",
        "delete": "1",
        "created_at": "2025-07-29T17:16:47.000000Z",
        "updated_at": "2025-07-29T17:16:47.000000Z",
        "menu": "reporte-incidencias"
      },
      {
        "id": 821,
        "id_role": 1,
        "view": "0",
        "new": "0",
        "edit": "1",
        "delete": "1",
        "created_at": "2025-07-29T17:16:47.000000Z",
        "updated_at": "2025-07-29T17:16:47.000000Z",
        "menu": "operacion-nueva_incidencia"
      },
      {
        "id": 822,
        "id_role": 1,
        "view": "0",
        "new": "1",
        "edit": "0",
        "delete": "1",
        "created_at": "2025-07-29T17:16:47.000000Z",
        "updated_at": "2025-07-29T17:16:47.000000Z",
        "menu": "operacion-derivacion"
      },
    
    ]
  }
]
```