<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ExportImportController extends Controller
{
    // Método para exportar usuarios (ya existente)
    public function exportUsuarios()
    {
        // Obtener datos desde la API
        $response = Http::get('http://localhost:3000/usuarios');
        $usuarios = $response->json();

        // Crear un nuevo archivo Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nombre');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Rol');

        // Agregar datos
        $row = 2;
        foreach ($usuarios as $usuario) {
            $sheet->setCellValue('A' . $row, $usuario['_id']);
            $sheet->setCellValue('B' . $row, $usuario['nombre']);
            $sheet->setCellValue('C' . $row, $usuario['email']);
            $sheet->setCellValue('D' . $row, $usuario['rol']);
            $row++;
        }

        // Crear archivo y enviarlo como respuesta
        $writer = new Xlsx($spreadsheet);
        $filename = 'usuarios.xlsx';

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    // Método para importar usuarios desde un archivo Excel
    public function importUsuarios(Request $request)
    {
        // Validar que se haya subido un archivo
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
    
        // Obtener el archivo subido
        $file = $request->file('file');
    
        // Cargar el archivo Excel
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
    
        // Obtener los datos de las filas
        $rows = $sheet->toArray();
    
        // Eliminar la primera fila (encabezados)
        array_shift($rows);
    
        // Procesar cada fila
        foreach ($rows as $row) {
            // Verificar que la fila tenga al menos 3 columnas
            if (count($row) < 3) {
                return back()->with('error', 'El archivo Excel no tiene el formato correcto. Asegúrate de que tenga 3 columnas: Nombre, Email, Rol.');
            }
    
            // Generar una contraseña aleatoria
            $password = bcrypt(Str::random(10));
    
            // Crear el array de datos del usuario
            $usuario = [
                'nombre' => $row[0], // Columna A: Nombre
                'email' => $row[1],  // Columna B: Email
                'password' => $password,
                'rol' => $row[2],    // Columna C: Rol
            ];
    
            // Enviar los datos a la API
            $response = Http::post('http://localhost:3000/usuarios', $usuario);
    
            // Manejar la respuesta de la API si es necesario
            if ($response->failed()) {
                return back()->with('error', 'Error al importar usuarios');
            }
        }
    
        return back()->with('success', 'Usuarios importados correctamente');
    }
    // Método para exportar alertas a Excel
    public function exportAlertas()
    {
        // Obtener datos desde la API
        $response = Http::get('http://localhost:3000/alertas');
        $alertas = $response->json();

        // Crear un nuevo archivo Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Mensaje');
        $sheet->setCellValue('C1', 'Fecha');
        $sheet->setCellValue('D1', 'Resuelta');

        // Agregar datos
        $row = 2;
        foreach ($alertas as $alerta) {
            $sheet->setCellValue('A' . $row, $alerta['_id']);
            $sheet->setCellValue('B' . $row, $alerta['mensaje']);
            $sheet->setCellValue('C' . $row, $alerta['fecha']);
            $sheet->setCellValue('D' . $row, $alerta['resuelta'] ? 'Sí' : 'No');
            $row++;
        }

        // Crear archivo y enviarlo como respuesta
        $writer = new Xlsx($spreadsheet);
        $filename = 'alertas.xlsx';

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    // Método para importar alertas desde Excel
    public function importAlertas(Request $request)
{
    // Validar que se haya subido un archivo
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
    ]);

    // Obtener el archivo subido
    $file = $request->file('file');

    // Cargar el archivo Excel
    $spreadsheet = IOFactory::load($file->getPathname());
    $sheet = $spreadsheet->getActiveSheet();

    // Obtener los datos de las filas
    $rows = $sheet->toArray();

    // Eliminar la primera fila (encabezados)
    array_shift($rows);

    // Procesar cada fila
    foreach ($rows as $row) {
        // Verificar que la fila tenga al menos 4 columnas
        if (count($row) < 4) {
            return back()->with('error', 'El archivo Excel no tiene el formato correcto. Asegúrate de que tenga 4 columnas: Sensor (ID), Mensaje, Fecha, Resuelta.');
        }

        // Crear el array de datos de la alerta
        $alerta = [
            'sensor' => $row[0], // Columna A: Sensor (ID)
            'mensaje' => $row[1], // Columna B: Mensaje
            'fecha' => $row[2],   // Columna C: Fecha
            'resuelta' => strtolower($row[3]) === 'sí' ? true : false, // Columna D: Resuelta
        ];

        // Enviar los datos a la API
        $response = Http::post('http://localhost:3000/alertas', $alerta);

        // Manejar la respuesta de la API si es necesario
        if ($response->failed()) {
            return back()->with('error', 'Error al importar alertas');
        }
    }

    return back()->with('success', 'Alertas importadas correctamente');
}
    // Método para exportar sensores a Excel
    public function exportSensores()
    {
        // Obtener datos desde la API
        $response = Http::get('http://localhost:3000/sensores');
        $sensores = $response->json();
    
        // Crear un nuevo archivo Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Encabezados
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Poste (ID)');
        $sheet->setCellValue('C1', 'Estado');
        $sheet->setCellValue('D1', 'Última Revisión');
    
        // Agregar datos
        $row = 2;
        foreach ($sensores as $sensor) {
            // Extraer el ID del poste (si existe)
            $posteId = $sensor['poste'] ? $sensor['poste']['_id'] : 'N/A';
    
            // Asignar valores a las celdas
            $sheet->setCellValue('A' . $row, (string) $sensor['_id']);
            $sheet->setCellValue('B' . $row, (string) $posteId);
            $sheet->setCellValue('C' . $row, (string) $sensor['estado']);
            $sheet->setCellValue('D' . $row, Carbon::parse($sensor['ultimaRevision'])->format('Y-m-d H:i:s'));
            $row++;
        }
    
        // Crear archivo y enviarlo como respuesta
        $writer = new Xlsx($spreadsheet);
        $filename = 'sensores.xlsx';
    
        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    // Método para importar sensores desde Excel
    public function importSensores(Request $request)
    {
        // Validar que se haya subido un archivo
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Obtener el archivo subido
        $file = $request->file('file');

        // Cargar el archivo Excel
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();

        // Obtener los datos de las filas
        $rows = $sheet->toArray();

        // Eliminar la primera fila (encabezados)
        array_shift($rows);

        // Procesar cada fila
        foreach ($rows as $row) {
            // Verificar que la fila tenga al menos 3 columnas
            if (count($row) < 3) {
                return back()->with('error', 'El archivo Excel no tiene el formato correcto. Asegúrate de que tenga 3 columnas: Poste (ID), Estado, Última Revisión.');
            }

            // Crear el array de datos del sensor
            $sensor = [
                'poste' => $row[0], // Columna A: Poste (ID)
                'estado' => $row[1], // Columna B: Estado
                'ultimaRevision' => $row[2], // Columna C: Última Revisión
            ];

            // Enviar los datos a la API
            $response = Http::post('http://localhost:3000/sensores', $sensor);

            // Manejar la respuesta de la API si es necesario
            if ($response->failed()) {
                return back()->with('error', 'Error al importar sensores');
            }
        }

        return back()->with('success', 'Sensores importados correctamente');
    }
    // Método para exportar postes a Excel
    public function exportPostes()
    {
        // Obtener datos desde la API
        $response = Http::get('http://localhost:3000/postes');
        $postes = $response->json();

        // Crear un nuevo archivo Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Ubicación');
        $sheet->setCellValue('C1', 'Estado');
        $sheet->setCellValue('D1', 'Sensores (IDs)');

        // Agregar datos
        $row = 2;
        foreach ($postes as $poste) {
            // Convertir el array de sensores a una cadena separada por comas
            $sensoresIds = implode(', ', $poste['sensores'] ?? []);

            // Asignar valores a las celdas
            $sheet->setCellValue('A' . $row, (string) $poste['_id']);
            $sheet->setCellValue('B' . $row, (string) $poste['ubicacion']);
            $sheet->setCellValue('C' . $row, (string) $poste['estado']);
            $sheet->setCellValue('D' . $row, $sensoresIds);
            $row++;
        }

        // Crear archivo y enviarlo como respuesta
        $writer = new Xlsx($spreadsheet);
        $filename = 'postes.xlsx';

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    // Método para importar postes desde Excel
    public function importPostes(Request $request)
{
    // Validar que se haya subido un archivo
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
    ]);

    // Obtener el archivo subido
    $file = $request->file('file');

    // Cargar el archivo Excel
    $spreadsheet = IOFactory::load($file->getPathname());
    $sheet = $spreadsheet->getActiveSheet();

    // Obtener los datos de las filas
    $rows = $sheet->toArray();

    // Eliminar la primera fila (encabezados)
    array_shift($rows);

    // Procesar cada fila
    foreach ($rows as $row) {
        // Verificar que la fila tenga al menos 3 columnas
        if (count($row) < 3) {
            return back()->with('error', 'El archivo Excel no tiene el formato correcto. Asegúrate de que tenga 3 columnas: Ubicación, Estado, Sensores (IDs).');
        }

        // Normalizar el estado (convertir a minúsculas)
        $estado = strtolower(trim($row[1]));

        // Validar que el estado sea uno de los valores permitidos
        if (!in_array($estado, ['activo', 'inactivo', 'mantenimiento'])) {
            return back()->with('error', 'El estado "' . $row[1] . '" no es válido. Los valores permitidos son: activo, inactivo, mantenimiento.');
        }

        // Crear el array de datos del poste
        $poste = [
            'ubicacion' => $row[0], // Columna A: Ubicación
            'estado' => $estado,    // Columna B: Estado (normalizado)
            'sensores' => !empty($row[2]) ? array_map('trim', explode(',', $row[2])) : [], // Columna C: Sensores (IDs)
        ];

        // Enviar los datos a la API
        $response = Http::post('http://localhost:3000/postes', $poste);

        // Manejar la respuesta de la API si es necesario
        if ($response->failed()) {
            return back()->with('error', 'Error al importar postes: ' . $response->body());
        }
    }

    return back()->with('success', 'Postes importados correctamente');
}
}
