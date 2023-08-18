<?php

namespace App\Traits;

use App\Job;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait ReportsTxt
{



    protected $codeIes = 22293;
    protected $separatorSingle = '|$|';
    protected $separatorDouble = '|$$|';
    protected $yes = 'S';
    protected $not = 'N';
    protected $urlBase = 'urlbase';
    protected $baseSalary = 1160000;

    public function PositionsTxt()
    {

        $init =  request()->get('inicio');
        $end =  request()->get('fin');
        $date =  Carbon::now()->format('mY');

        $data = DB::select("SELECT
	    '22293' AS codigoPrestador,
	    jobs.id AS codigoVacante,
	    title AS tituloVacante,
	    replace(jobs.description, '\r', ' ') AS descripcionVacante, (job_experience * 12) AS tiempoExperienciaRelacionada,
	    career_levels.code AS nivelEstudiosRequerido,
	    IF(
	        career_levels.code = 5,
	        degree_level,
	        IF(
	            career_levels.code = 6,
	            degree_level,
	            IF(
	                career_levels.code = 7,
	                degree_level,
	                IF(career_levels.code = 8, degree_level, 'NA')
	            )
	        )
	    ) AS disciplinaOProfesion,
	    IF(
	        salary_from = 0,
	        IF(salary_to = 0, 'A convenir', salary_to),
	        IF(
	            salary_to = 0,
	            salary_from,
	            CONCAT(salary_from, '-', salary_to)
	        )
	    ) AS salario,
	    num_of_positions AS cantidadVacantes,
	    functional_area AS cargo,
	    IF(tipo_identificacion = 'NIT', 1, 2) AS codigoTipoDocumentoEmpleador,
	    identificacion AS numeroIdentificacionEmpleador,
	    name AS razonSocial,
	    IF(show_info = 'si', 'S', 'N') AS solicitudExcepcionPublicacion,
	    CONCAT(
	        date_format(jobs.created_at, '%d'),
	        '/',
	        date_format(jobs.created_at, '%m'),
	        '/',
	        date_format(jobs.created_at, '%Y')
	    ) AS fechaPublicacion,
	    CONCAT(
	        date_format(jobs.expiry_date, '%d'),
	        '/',
	        date_format(jobs.expiry_date, '%m'),
	        '/',
	        date_format(jobs.expiry_date, '%Y')
	    ) AS fechaVencimiento,
	    divipola AS codigoMunicipio,
	    industry AS sectorEconomico,
	    IF(
	        jobs.job_type_id = 4,
	        2,
	        IF(
	            jobs.job_type_id = 2,
	            4,
	            IF(
	                jobs.job_type_id = 5,
	                6,
	                IF(
	                    jobs.job_type_id = 3,
	                    1,
	                    IF(jobs.job_type_id = 26, 5, 3)
	                )
	            )
	        )
	    ) AS tipoContrato,
	    is_freelance AS teletrabajo,
	    0 AS discapacidad,
	    CONCAT(
	        'https://bolsadeempleo.itc.edu.co/job/',
	        jobs.slug
	    ) AS url
	FROM
	    jobs
	    INNER JOIN job_experiences ON jobs.job_experience_id = job_experiences.job_experience_id
	    INNER JOIN career_levels ON jobs.career_level_id = career_levels.career_level_id
	    INNER JOIN degree_levels ON jobs.degree_level_id = degree_levels.degree_level_id
	    INNER JOIN functional_areas ON jobs.functional_area_id = functional_areas.id
	    INNER JOIN companies ON jobs.company_id = companies.id
	    INNER JOIN cities ON jobs.city_id = cities.city_id
	    INNER JOIN industries ON companies.industry_id = industries.industry_id
	    INNER JOIN job_types ON jobs.job_type_id = job_types.job_type_id
	WHERE
		companies.is_active = 1
		AND 
	    jobs.created_at BETWEEN '$init'
	    AND '$end'
	    
	ORDER BY
	    jobs.created_at ASC;
");

        $file = $this->codeIes . Carbon::parse($end)->format('Ymd') . ".txt";

        $txt = fopen($file, "w") or die("Unable to open file!");

        foreach ($data as $datum) {

            if ($datum->cantidadVacantes >= 1) {

                fwrite($txt,        $datum->codigoPrestador  . $this->separatorDouble);

                fwrite($txt,        $datum->codigoVacante . $this->separatorDouble);

                fwrite($txt,        $this->htmlToPlainText($datum->tituloVacante) . $this->separatorDouble);

                fwrite($txt,        $this->htmlToPlainText($datum->descripcionVacante) . $this->separatorDouble);

                fwrite($txt,        $this->replaceyears($datum->tiempoExperienciaRelacionada) . $this->separatorDouble);

                fwrite($txt,        $this->htmlToPlainText($datum->nivelEstudiosRequerido) . $this->separatorDouble);

                fwrite($txt,        $this->htmlToPlainText($datum->disciplinaOProfesion) . $this->separatorDouble);

                fwrite($txt,        $datum->salario . $this->separatorDouble);

                fwrite($txt,        $datum->cantidadVacantes . $this->separatorDouble);

                fwrite($txt,        $this->htmlToPlainText($datum->cargo) . $this->separatorDouble);

                fwrite($txt,        $datum->codigoTipoDocumentoEmpleador . $this->separatorDouble);

                fwrite($txt,        $datum->numeroIdentificacionEmpleador . $this->separatorDouble);

                fwrite($txt,        $this->htmlToPlainText($datum->razonSocial) . $this->separatorDouble);

                fwrite($txt,        $datum->solicitudExcepcionPublicacion . $this->separatorDouble);

                fwrite($txt,        $datum->fechaPublicacion . $this->separatorDouble);

                fwrite($txt,        $datum->fechaVencimiento . $this->separatorDouble);

                fwrite($txt,        $datum->codigoMunicipio . $this->separatorDouble);

                fwrite($txt,        $this->htmlToPlainText($datum->sectorEconomico) . $this->separatorDouble);

                fwrite($txt,        $this->htmlToPlainText($datum->tipoContrato) . $this->separatorDouble);

                fwrite($txt,        $datum->teletrabajo . $this->separatorDouble);

                fwrite($txt,        $datum->discapacidad . $this->separatorDouble);

                fwrite($txt,        $datum->url);

                fwrite($txt,  PHP_EOL);
            }
        }

        fclose($txt);

        header('Content-Description: File Transfer');

        header('Content-Disposition: attachment; filename=' . basename($file));

        header('Expires: 0');

        header('Cache-Control: must-revalidate');

        header('Pragma: public');

        header('Content-Length: ' . filesize($file));

        header("Content-Type: text/plain");

        return readfile($file);
    }

    public function PracticasLaboralesTxt()
    {
        $file =  'PL' . $this->codeIes . Carbon::now()->format('Ymd') .  ".txt";

        $txt = fopen($file, "w") or die("Unable to open file!");

        fclose($txt);

        header('Content-Description: File Transfer');

        header('Content-Disposition: attachment; filename=' . basename($file));

        header('Expires: 0');

        header('Cache-Control: must-revalidate');

        header('Pragma: public');

        header('Content-Length: ' . filesize($file));

        header("Content-Type: text/plain");

        return readfile($file);
    }

    public function OferentesMensualTxt()
    {
        $file = '';
        $init =  request()->get('inicio');
        $end =  request()->get('fin');
        $date =  Carbon::parse($end)->format('mY');

        $data = DB::select("SELECT
        02 AS codigoRegistro,
        22293 AS codigoPrestador,
        1 AS tipoIdentificacion,
        national_id_card_number AS numeroIdentificacion,
        iso31661 AS paisResidencia,
        REPLACE(states.divipola, '000', '') AS departamento,
        cities.divipola AS municipio,
        date_format(users.updated_at, '%d%m%Y') AS fechaActualizacion
    FROM
        users
        LEFT JOIN countries ON users.country_id = countries.country_id
        LEFT JOIN states ON users.state_id = states.state_id
        LEFT JOIN cities ON users.city_id = cities.city_id
    WHERE
        users.updated_at BETWEEN '$init'
        AND '$end'
    ORDER BY users.updated_at ASC");

        $header =  DB::select("SELECT
        01 AS codigoTipoRegistro,
        22293 AS codigoUnicoPrestador,
        COUNT(id) AS numeroTotalDeRegistros,
        date_format(now(), '%d%m%Y') AS fechaArchivo
    FROM
        users
    WHERE
        users.updated_at BETWEEN '$init'
        AND '$end'")[0];

        $footer =  DB::select("SELECT
        99 AS codigoTipoRegistro,
        22293 AS codigoUnicoPrestador,
        COUNT(id) AS numeroTotalDeRegistros,
        date_format(now(), '%d%m%Y') AS fechaArchivo
    FROM
        users
    WHERE
        users.updated_at BETWEEN '$init'
        AND '$end'")[0];

        $file = "DBO22293$date.txt";

        $txt = fopen($file, "w") or die("Unable to open file!");

        fwrite($txt,        $header->codigoTipoRegistro . $this->separatorSingle);

        fwrite($txt,        $header->codigoUnicoPrestador . $this->separatorSingle);

        fwrite($txt,         $header->numeroTotalDeRegistros . $this->separatorSingle);

        fwrite($txt,        Carbon::now()->format('dmY'));

        fwrite($txt,  PHP_EOL);

        foreach ($data as $datum) {

            if (isset($datum->municipio)) {


                fwrite($txt,        $datum->codigoRegistro . $this->separatorSingle);

                fwrite($txt,        $datum->codigoPrestador . $this->separatorSingle);

                fwrite($txt,        $datum->tipoIdentificacion . $this->separatorSingle);

                fwrite($txt,        $datum->numeroIdentificacion . $this->separatorSingle);

                fwrite($txt,        $datum->paisResidencia . $this->separatorSingle);

                fwrite($txt,        $datum->departamento . $this->separatorSingle);

                fwrite($txt,        $datum->municipio . $this->separatorSingle);

                fwrite($txt,        $datum->fechaActualizacion);

                fwrite($txt,  PHP_EOL);
            }
        }

        fwrite($txt,        $footer->codigoTipoRegistro . $this->separatorSingle);

        fwrite($txt,        $footer->codigoUnicoPrestador . $this->separatorSingle);

        fwrite($txt,        $footer->numeroTotalDeRegistros . $this->separatorSingle);

        fwrite($txt,        $footer->numeroTotalDeRegistros . $this->separatorSingle);

        fwrite($txt,        Carbon::now()->format('dmY'));

        fwrite($txt,  PHP_EOL);

        // fwrite($txt,  "\r\n");

        fclose($txt);

        header('Content-Description: File Transfer');

        header('Content-Disposition: attachment; filename=' . basename($file));

        header('Expires: 0');

        header('Cache-Control: must-revalidate');

        header('Pragma: public');

        header('Content-Length: ' . filesize($file));

        header("Content-Type: text/plain");

        return readfile($file);
    }

    public function OferentesSemestralTxt()
    {

        $init =  request()->get('inicio');
        $end =  request()->get('fin');
        $date =  Carbon::parse($end)->format('mY');

        $header = DB::select("SELECT
                        01 AS codigoTipoRegistro,
                        22293 AS codigoUnicoPrestador,
                        COUNT(id) AS numeroTotalDeRegistros,
                        date_format(now(), '%d%m%Y') AS fechaArchivo
                        FROM
                        users
                        WHERE
                        users.updated_at BETWEEN '$init'
                        AND '$end'")[0];

        $footer = DB::select("SELECT
        99 AS codigoTipoRegistro,
        22293 AS codigoUnicoPrestador,
        COUNT(id) AS numeroTotalDeRegistros,
        SUM(1) AS conteoDeControl,
        date_format(LAST_DAY(MAX(updated_at)), '%d%m%Y') AS fechaDeCorte
    FROM
        users
    WHERE
        users.updated_at BETWEEN '$init'
        AND '$end'")[0];

        $data = DB::select("SELECT
        02 AS codigoRegistro,
        22293 AS codigoPrestador,
        date_format(date_of_birth, '%d%m%Y') AS fechaNacimiento,
        countries.iso31661 AS PaisNacimiento,
        SUBSTRING(states.divipola, 1, 2) AS departamentoNacimiento,
        SUBSTRING(cities.divipola, 3, 3) AS municipioNacimiento,
        gender_id as sexo,
        conuntriesr.	iso31661 AS paisResidencia,
        SUBSTRING(statesr.divipola, 1, 2) AS departamentoResidencia,
        SUBSTRING(citiesr.divipola, 3, 3) AS municipioResidencia,
        'FA' AS codigoSegmentoFormacionAcademica,
        functional_area AS tituloFormacionAcademica,
        level_education AS nivelEducativo,
        date_format(academic_training_completion_date, '%d%m%Y') AS fechaFinalizacionFormacionAcademica,
        state_of_formation AS estadoFormacion,
        170 AS paisFormacion,
        'EL' AS codigoSegmentoExperienciaLaboral,
        '' AS nombreCargo,
        '' AS ocupacion,
        '' AS paisExperiencia,
        '' AS departamentoExperiencia,
        '' AS municipioExperiencia,
        '' AS fechaInicioExperiencia,
        '' AS fechaFinExperiencia,
        'MO' AS codigoSegmentoManoDeObra,
        range_expected_salary AS aspiracionSalarial
    FROM
        users
        LEFT JOIN countries ON users.nationality_id = countries.country_id
        LEFT JOIN states ON users.state_birth_id = states.state_id
        LEFT JOIN cities ON users.city_birth_id = cities.city_id
        LEFT JOIN countries AS conuntriesr ON users.country_id = conuntriesr.country_id
        LEFT JOIN states AS statesr ON users.state_id = statesr.state_id
        LEFT JOIN cities AS citiesr ON users.city_id = citiesr.city_id
        LEFT JOIN career_levels ON users.career_level_id = career_levels.career_level_id
        LEFT JOIN functional_areas ON users.functional_area_id = functional_areas.functional_area_id
    WHERE
        users.updated_at BETWEEN '$init'
        AND '$end' ");


        $file = "IBHV22293$date.txt";

        $txt = fopen($file, "w") or die("Unable to open file!");

        fwrite($txt, $header->codigoTipoRegistro . $this->separatorSingle);
        fwrite($txt, $header->codigoUnicoPrestador . $this->separatorSingle);
        fwrite($txt, $header->numeroTotalDeRegistros . $this->separatorSingle);
        fwrite($txt, $header->fechaArchivo);
        fwrite($txt,  PHP_EOL);
        // fwrite($txt,  "\r\n");


        foreach ($data as $datum) {

            fwrite($txt,        '0' . $datum->codigoRegistro . $this->separatorSingle);

            fwrite($txt,         $datum->codigoPrestador . $this->separatorSingle);

            fwrite($txt,         $datum->fechaNacimiento . $this->separatorSingle);

            fwrite($txt,         $datum->PaisNacimiento . $this->separatorSingle);

            fwrite($txt,         $datum->departamentoNacimiento . $this->separatorSingle);

            fwrite($txt,         $datum->municipioNacimiento . $this->separatorSingle);

            fwrite($txt,         $datum->sexo . $this->separatorSingle);

            fwrite($txt,         $datum->paisResidencia . $this->separatorSingle);

            fwrite($txt,         $datum->departamentoResidencia . $this->separatorSingle);

            fwrite($txt,         $datum->municipioResidencia . $this->separatorSingle);

            fwrite($txt,        $datum->codigoSegmentoFormacionAcademica . $this->separatorSingle);

            // foreach ($datum->profileEducation as $edu) {

            fwrite($txt,        $datum->tituloFormacionAcademica . $this->separatorSingle);

            fwrite($txt,        $datum->nivelEducativo . $this->separatorSingle);

            fwrite($txt,        $datum->fechaFinalizacionFormacionAcademica . $this->separatorSingle);

            fwrite($txt,        $datum->estadoFormacion . $this->separatorSingle);

            fwrite($txt,        $datum->paisFormacion . $this->separatorSingle);
            // }

            fwrite($txt,        $datum->codigoSegmentoExperienciaLaboral . $this->separatorSingle);

            // foreach ($datum->profileExperience as $exp) {

            fwrite($txt,         $datum->nombreCargo . $this->separatorSingle);

            fwrite($txt,         $datum->ocupacion . $this->separatorSingle);

            fwrite($txt,         $datum->paisExperiencia . $this->separatorSingle);

            fwrite($txt,         $datum->departamentoExperiencia . $this->separatorSingle);

            fwrite($txt,         $datum->municipioExperiencia . $this->separatorSingle);

            fwrite($txt,         $datum->fechaInicioExperiencia . $this->separatorSingle);

            fwrite($txt,         $datum->fechaFinExperiencia . $this->separatorSingle);
            // }

            // $s = 11;

            // $b = 1060000;

            // $mi = $this->htmlToPlainText($datum->aspiracionSalarial);

            // if ($mi < $b)  $s = 1;

            // if ($mi == $b)  $s = 2;

            // if ($mi >= $b && $mi < 2 * $b)  $s = 3;

            // if ($mi >= 2 * $b && $mi < 4 * $b)  $s = 4;

            // if ($mi >= 4 * $b && $mi < 6 * $b)  $s = 5;

            // if ($mi >= 6 * $b && $mi < 9 * $b)  $s = 6;

            // if ($mi >= 9 * $b && $mi < 12 * $b)  $s = 7;

            // if ($mi >= 12 * $b && $mi < 15 * $b)  $s = 8;

            // if ($mi >= 15 * $b && $mi < 19 * $b)  $s = 9;

            // if ($mi >= 20 * $b) $s = 10;

            fwrite($txt,        $datum->codigoSegmentoManoDeObra . $this->separatorSingle);

            fwrite($txt,        $datum->aspiracionSalarial);

            fwrite($txt,  PHP_EOL);

            // fwrite($txt,  "\r\n");
        }


        fwrite($txt, 99 . $footer->codigoTipoRegistro . $this->separatorSingle);
        fwrite($txt, $footer->codigoUnicoPrestador . $this->separatorSingle);
        fwrite($txt, $footer->numeroTotalDeRegistros . $this->separatorSingle);
        fwrite($txt, $footer->conteoDeControl . $this->separatorSingle);
        fwrite($txt, Carbon::now()->format('dmY'));
        fwrite($txt,  PHP_EOL);
        // fwrite($txt,  "\r\n");

        fclose($txt);

        header('Content-Description: File Transfer');

        header('Content-Disposition: attachment; filename=' . basename($file));

        header('Expires: 0');

        header('Cache-Control: must-revalidate');

        header('Pragma: public');

        header('Content-Length: ' . filesize($file));

        header("Content-Type: text/plain");

        return readfile($file);
    }
}
