<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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
}