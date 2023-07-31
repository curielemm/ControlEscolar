<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
*/

//Rutas de Administrador

use App\Http\Controllers\PlanEstudioController;
use GuzzleHttp\Middleware;

Route::group(['middleware' => ['auth', 'EsAdmin']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('listarUsuario', 'AdministradorController@listarUsuario')->name('listarUsuario');
    Route::get('rolesUsuarios', 'AdministradorController@listarUsuariosRoles')->name('rolesUsuarios');
    Route::post('eliminarUsuario/{id}', 'AdministradorController@eliminarUsuario')->name('eliminarUsuario');
    Route::post('activarUsuario/{id}', 'AdministradorController@activarUsuario')->name('activarUsuario');
    Route::post('cambiarRole/{clave_usuario}', 'AdministradorController@editarRole')->name('cambiarRole');
    Route::post('eliminarAnalista/{clave_usuario}', 'AdministradorController@eliminarAnalista')->name('eliminarAnalista');
    Route::get('listaAnalistas', 'AdministradorController@listaAnalistas')->name('listaAnalistas');
    Route::get('listaescolar', 'AdministradorController@lista_users_CtrlEscolar')->name('listaescolar');
    Route::get('asignarInstitucion', 'AdministradorController@asignarInstitucion')->name('asignarInstitucion');
    Route::post('asignar', 'AdministradorController@asignar')->name('asignar');
    Route::get('su_msu', 'AdministradorController@ins_suOmsu')->name('su_msu');
    Route::get('planes_su_msu', 'AdministradorController@planes_suOmsu')->name('planes_su_msu');
    Route::get('ver_su_msu', 'AdministradorController@ver_ins_suOmsu')->name('ver_su_msu');
    Route::get('instituciones', 'ControllerUser@regresarInstitucion')->name('instituciones');
    // Route::get('registroInstitucion', 'AnalistaController@registrarInstitucion')->name('registroInstitucion');
    Route::post('registroIns', 'AnalistaController@registroIns')->name('registroIns');
    //Listado de Instituciones
    Route::get('listarInstitucion', 'AnalistaController@listarInstitucion')->name('listarInstitucion');
    Route::get('listarInstitucionMSU', 'AnalistaController@listarInstitucionMSU')->name('listarInstitucionMSU');
    Route::get('listarInstitucionCPT', 'AnalistaController@listarInstitucionCPT')->name('listarInstitucionCPT');
    Route::get('editarInstitucion/{clave_cct}', 'AnalistaController@editar_institucion')->name('editarInstitucion');
    Route::post('updateInstitucion/{clave_cct}', 'AnalistaController@edit_institucion')->name('updateInstitucion');
    Route::get('editarInstitucionMSU/{clave_cct}', 'AnalistaController@editar_institucionMSU')->name('editarInstitucionMSU');
    //Planes de estudio
    Route::get('registroPlan', 'PlanEstudioController@registroPlanEstudio')->name('registroPlan');
    Route::post('insertarPlan', 'PlanEstudioController@insertPlanEstudio')->name('insertarPlan');

    Route::post('eliminarPlan/{clave_plan}', 'PlanEstudioController@eliminarPlan')->name('eliminarPlan');

    //Firmulario materia
    Route::get('FormularioMaterias', 'ControllerMateria@ver_formularioMateria')->name('formularioMaterias');
    Route::get('FormularioMaterias', 'ControllerMateria@ver_selects')->name('FormularioMaterias');
    Route::post('insertarMateria', 'ControllerMateria@inserMateria')->name('registroMateria');
    Route::get('avisoMateria', 'ControllerMateria@avisoMat')->name('avisoMateria');
    Route::get('listarMaterias', 'ControllerMateria@listarMaterias')->name('listarMaterias');
    Route::get('eliminarInstitucion/{clave_institucion}', 'AnalistaController@eliminarInstitucion')->name('eliminarInstitucion');
    Route::get('listMat/{rvoe}/{vigencia}', 'ControllerMateria@listMat')->name('listMat');


    Route::get('menuMaterias', 'ControllerAsignatura@menuAgregarMaterias')->name('menuMaterias');
    Route::get('agregarCSV', 'ControllerAsignatura@vistaAgregarMateriaCSV')->name('agregarCSV');
    Route::get('formAgregarCSV/{rvoe}/{clave_cct}/{vigencia}', 'ControllerAsignatura@formAgregarAsigCSV')->name('formAgregarCSV');
    Route::post('agregarData', 'ControllerAsignatura@agregarMateriasCSV')->name('agregarData');
    ////nuevos formularios

    Route::get('FormularioInstituciones', 'ControllerInstitucion@ver_RegistroInst')->name('FormularioInstituciones');
    Route::get('FormularioInstituciones', 'ControllerInstitucion@ver_tipo_directivos');

    Route::post('insertarInstitucion', 'ControllerInstitucion@insertEscuela')->name('registroInstitucion');

    Route::post('store', 'ControllerInstitucion@store')->name('store');

    //Route::post('insertarInstitucion','ControllerInstitucion@insert')->name('registroInstitucion');

    Route::get('confirmacion', 'ControllerInstitucion@aviso')->name('confirmacion');

    Route::get('logs', 'AdministradorController@logs')->name('logs');
    Route::get('InsertarPlan', function () {
        return view('InsertarPlanEstudio');
    });

    Route::get('FormularioPlanes', 'PlanEstudioController@ver_insertPlan')->name('FormularioPlanes');
    Route::get('FormularioPlanes', 'PlanEstudioController@ver_selects')->name('FormularioPlanes');
    Route::post('insertarPlanes', 'PlanEstudioController@insertPlan')->name('registroPlanes');
    Route::get('avisoPlan', 'PlanEstudioController@avisoPlan')->name('avisoPlan');
    Route::get('PlanesVarios', 'PlanEstudioController@ver_insertPlanes')->name('PlanesVarios');
    Route::get('PlanesVarios', 'PlanEstudioController@planesVarios')->name('PlanesVarios');
    Route::post('PlanesVarios', 'PlanEstudioController@insertarPV')->name('registroPlanesVarios');
    Route::get('Instituciones', function () {
        return view('validacionInstitucion');
    });
    Route::get('FormularioInstituciones2', 'ControllerInstitucion@ver_RegistroInst2')->name('FormularioInstituciones2');
    Route::get('FormularioInstituciones2', 'ControllerInstitucion@ver_tipo_directivos');
    Route::post('validarPlan', 'PlanEstudioController@store')->name('validarPlan');
    Route::get('FormularioMSU', 'ControllerInstitucion@ver_formMSU')->name('FormularioMSU');
    Route::get('FormularioMSU', 'ControllerInstitucion@ver_tipo_directivos2');
    Route::post('insertarInstitucionMSU', 'ControllerInstitucion@insertEscuelaMSU')->name('registroInstitucionMSU');
    Route::get('avisoMSU', 'ControllerInstitucion@avisoMSU')->name('avisoMSU');
    Route::get('PlanesMSU', 'PlanEstudioController@ver_planesmsu')->name('PlanesMSU');
    Route::get('PlanesMSU', 'PlanEstudioController@ver_selectsMSU');
    Route::post('PlanesMSU', 'PlanEstudioController@insertPlanMSU')->name('registroPlanesMSU');
    Route::get('avisoPlanMSU', 'PlanEstudioController@avisoPlanMSU')->name('avisoPlanMSU');
    Route::get('PlanesVariosMSU', 'PlanEstudioController@ver_insertPlanesMSU')->name('PlanesVariosMSU');
    Route::get('PlanesVariosMSU', 'PlanEstudioController@planesVariosMSU')->name('PlanesVariosMSU');
    Route::post('PlanesVariosMSU', 'PlanEstudioController@insertarPVMSU')->name('registroPlanesMSUVarios');
    Route::get('avisoPlanesMSU', 'PlanEstudioController@avisoPlanesMSU')->name('avisoPlanesMSU');
    Route::get('avisoPlanesVarios', 'PlanEstudioController@avisoPlanesVarios')->name('avisoPlanesVarios');
    Route::get('FormularioCPT', 'ControllerInstitucion@ver_formCPT')->name('FormularioCPT');
    Route::get('FormularioCPT', 'ControllerInstitucion@selectCPT');
    Route::post('insertarInstitucionCPT', 'ControllerInstitucion@insertEscuelaCPT')->name('registroInstitucionCPT');
    Route::get('avisoCPT', 'ControllerInstitucion@avisoCPT')->name('avisoCPT');
    Route::get('PlanesCPT', 'PlanEstudioController@ver_planesCPT')->name('PlanesCPT');
    Route::get('PlanesCPT', 'PlanEstudioController@ver_selectsCPT');
    Route::post('PlanesCPT', 'PlanEstudioController@insertPlanCPT')->name('registroPlanesCPT');
    Route::get('avisoPlanCPT', 'PlanEstudioController@avisoPlanCPT')->name('avisoPlanCPT');
    Route::get('PlanesVariosCPT', 'PlanEstudioController@ver_planesVCPT')->name('PlanesVariosCPT');
    Route::get('PlanesVariosCPT', 'PlanEstudioController@planesVariosCPT')->name('PlanesVariosCPT');
    Route::post('PlanesVariosCPT', 'PlanEstudioController@insertPlanVCPT')->name('registroPlanesCPTVarios');
    Route::get('avisoPlanesCPT', 'PlanEstudioController@avisoPlanVCPT')->name('avisoPlanesCPT');
    Route::get('FormularioMateriaMSU', 'ControllerMateria@ver_formularioMateriaMSU')->name('formularioMateriaMSU');
    Route::get('FormularioMateriaMSU', 'ControllerMateria@ver_selectsMsu')->name('FormularioMateriaMSU');
    Route::post('insertarMateriaMSU', 'ControllerMateria@inserMateriaMSU')->name('registroMateriaMSU');
    Route::get('avisoMateriaMSU', 'ControllerMateria@avisoMatMSU')->name('avisoMateriaMSU');
    Route::get('FormularioMateriaCPT', 'ControllerMateria@ver_formularioMateriaCPT')->name('formularioMateriaCPT');
    Route::get('FormularioMateriaCPT', 'ControllerMateria@ver_selectsCpt')->name('FormularioMateriaCPT');
    Route::post('insertarMateriaCPT', 'ControllerMateria@insertarMateriaCPT')->name('registroMateriaCPT');
    Route::get('avisoMateriaCPT', 'ControllerMateria@avisoMatCPT')->name('avisoMateriaCPT');
    Route::get('planes/{clave_cct}', 'AnalistaController@listarPlanes')->name('planes');
    Route::get('planesMSU/{clave_cct}', 'AnalistaController@listarPlanes')->name('planesMSU');
    Route::get('planesCPT/{clave_cct}', 'AnalistaController@listarPlanes')->name('planesCPT');
    Route::get('vistaFichaTec/{clave_cct}', 'AnalistaController@fichaTecnica')->name('vistaFichaTec');
    Route::get('fichaTec', 'AnalistaController@pdf')->name('fichaTec');
    Route::get('pdf/{clave_cct}', 'AnalistaController@pdf')->name('pdf');
    Route::get('institucionAsignada/{clave_usuario}', 'AdministradorController@instituciones_de_analista')->name('institucionAsignada');
    Route::post('borrarInstitucionAsignada', 'AdministradorController@eliminarInstitucionAsignada')->name('borrarInstitucionAsignada');
    Route::get('reportes', 'AdministradorController@generarReporte')->name('reportes');
    Route::get('vistaReportes', 'AdministradorController@vistaReportes')->name('vistaReportes');
    Route::post('reportePDF', 'AnalistaController@pdf')->name('reportePDF');
    Route::get('vistaReportesCarrera', 'AdministradorController@vistaReportesCarrera')->name('vistaReportesCarrera');
    Route::post('consultajax', 'AdministradorController@consultaAjax')->name('consultajax');
    Route::post('consultajax2', 'AdministradorController@consultaAjax2')->name('consultajax2');
    Route::post('consultajax4', 'ControllerMateria@consultaAjax4')->name('consultajax4');

    Route::post('reporteCarreras', 'AnalistaController@pdfCarreraSU')->name('reporteCarreras');
    Route::get('agregarCiclo', 'AdministradorController@formCiclo')->name('agregarCiclo');
    Route::post('agregarCi', 'AdministradorController@agregarCiclo')->name('agregarCi');
    Route::get('formActualizarPlanSU/{clave_cct}/{rvoe}', 'PlanEstudioController@formActualizarPlanSU')->name('formActualizarPlanSU');
    Route::post('actuPlanSU/{rvoe}/{clave_cct}', 'PlanEstudioController@actualizarPlanSU')->name('actuPlanSU');


    Route::get('detallePlan/{rvoe}/{clave_cct}', 'AnalistaController@detallePlan')->name('detallePlan');
    Route::get('formActualizarAsignaturas/{rvoe}/{clave_cct}/{vigencia}', 'ControllerAsignatura@formActualizarAsignaturas')->name('formActualizarAsignaturas');
    Route::get('asignaturas/{clave_plan}', 'AnalistaController@listaAsignaturas')->name('asignaturas');
    Route::get('asignaturasSeriadas/{rvoe}/{vigencia}', 'ControllerAsignatura@materiasSeriadas')->name('asignaturasSeriadas');
    Route::post('agregarSeriacion', 'ControllerAsignatura@agregarclavesSeriacion')->name('agregarSeriacion');
    Route::get('agregarSeriacionCSV/{rvoe}/{vigencia}','ControllerAsignatura@formAgregarSeriadasCSV')->name('agregarSeriacionCSV');
    Route::post('agregarSeriadasCSV','ControllerAsignatura@agregarSeriadasCSV')->name('agregarSeriadasCSV');
});
//Rutas de Analista
Route::group(['middleware' => ['auth', 'EsAnalista']], function () {
    Route::get('dashboardAnalista', 'AnalistaController@dashboardAnalista')->name('dashboardAnalista');
    Route::get('planesAsig/{clave_cct}', 'AnalistaController@listarPlanesAnalista')->name('planesAsig');
    Route::get('misInstituciones', 'AnalistaController@misInstituciones')->name('misInstituciones');
    Route::get('perfilPlanAnalista/{rvoe}/{clave_cct}/{vigencia}', 'AnalistaController@perfilPlanesAnalista')->name('perfilPlanAnalista');
    Route::get('verGruposAnalista/{rvoe}/{clave_cct}/{vigencia}', 'ControllerGrupo@listaGrupoAnalista')->name('verGruposAnalista');
    Route::get('listarAlumnosAnalista/{clave_grupo}', 'ControllerGrupo@listarAlumnosAnalista')->name('listarAlumnosAnalista');
    Route::get('validarInscripcion/{clave_grupo}/{rvoe}/{vigencia}/{clave_cct}', 'ControllerGrupo@formvalidarInscripcion')->name('validarInscripcion');
    Route::post('validado', 'ControllerGrupo@validarInscripcion')->name('validado');
    //datos prueba
    Route::get('ajaxRequest', 'HomeController@ajaxRequest');
    Route::post('ajaxRequest', 'HomeController@ajaxRequestPost')->name("ajaxRequest");
    Route::get('validarAlumno/{curp}/{rvoe}/{vigencia}/{clave_cct}', 'ControllerAlumnos@validarAlu')->name('validarAlumno');
    Route::get('acuseInscripcion/{clave_grupo}/{rvoe}/{clave_cct}/{vigencia}', 'AnalistaController@acuseValidacionInscripcion')->name('acuseInscripcion');
    Route::get('detallePAnalista/{clave_cct}/{rvoe}', 'AnalistaController@detallePlanAnalista')->name('detallePAnalista');
    Route::get('validarAcreditacion/{clave_grupo}/{rvoe}/{vigencia}/{clave_cct}', 'ControllerGrupo@formvalidarAcreditacion')->name('validarAcreditacion');

    //validar inscripción
    Route::get('gruposValidarCalificacion/{rvoe}/{clave_cct}/{vigencia}', 'ControllerGrupo@verGruposAnalistaCalif')->name('gruposValidarCalificacion');
    Route::get('asignaturasCalificacion/{clave_grupo}/{no_periodo}/{vigencia}/{rvoe}', 'ControllerGrupo@menuAsignaturasCalif')->name('asignaturasCalificacion');
    Route::post('consultajaxT', 'ControllerMateria@consultajaxT')->name('consultajaxT');
    Route::post('completado', 'ControllerMateria@completado')->name('completado');

    //validar acreditacion
    Route::post('sendArray2', 'ControllerGrupo@validarAcreditacion')->name('sendArray2');
    Route::get('acuseAcreditacion/{clave_grupo}/{rvoe}/{clave_cct}/{vigencia}', 'ControllerGrupo@acusesAcreditaciónPorAsignatura')->name('acuseAcreditacion');

    Route::get('acreditacionSemestre', 'ControllerGrupo@vistaAcreditacionSemestre')->name('acreditacionSemestre');
    Route::get('reporteSemestral/{rvoe}/{clave_grupo}/{vigencia}', 'ControllerGrupo@vistaReporteSemestral')->name('reporteSemestral');
    Route::post('datosSem', 'ControllerGrupo@reporteSemestral')->name('datosSem');
    Route::get('verActa/{curp}/{clave_grupo}/{rvoe}/{vigencia}', 'ControllerGrupo@verActa')->name('verActa');
    Route::get('gruposEquivalencia/{rvoe}/{clave_cct}/{vigencia}', 'ControllerGrupo@vistaGrupoEquivalenciaRevalidacion')->name('gruposEquivalencia');
    Route::get('validarInscripcionEquivalencia/{clave_grupo}/{rvoe}/{vigencia}/{clave_cct}', 'ControllerGrupo@formvalidarInscripcionEquivalencia')->name('validarInscripcionEquivalencia');
    Route::get('validarAlumnoEquivalencia/{curp}/{rvoe}/{vigencia}/{clave_cct}', 'ControllerGrupo@validarAluEquivalencia')->name('validarAlumnoEquivalencia');
    Route::post('validadoEquivalencias', 'ControllerGrupo@validarInscripcionEquivalencia')->name('validadoEquivalencias');
    Route::get('acuseInscripcionEqu/{clave_grupo}/{rvoe}/{clave_cct}/{vigencia}', 'AnalistaController@acuseValidacionInscripcionEquivalencias')->name('acuseInscripcionEqu');
    Route::post('validarSemestre','ControllerGrupo@validarSemestre')->name('validarSemestre');
});
//Rutas de Control Escolar
Route::group(['middleware' => ['auth', 'EsControlEsc']], function () {
    Route::get('dashboardCtrlEscolar', 'CtrlEscolarController@dashboardCtrlEscolar')->name('dashboardCtrlEscolar');
    Route::get('formularioalumnos/{rvoe}/{vigencia}', 'ControllerAlumnos@ver_formularioalumnos')->name('formularioalumnos');
    Route::post('insertaralumnos/{rvoe}/{vigencia}', 'ControllerAlumnos@inserAlumnos')->name('registroAlumnos');
    Route::post('registroAlumnoEqu/{rvoe}/{vigencia}', 'ControllerAlumnos@insertarAlumnosEquivalencia')->name('registroAlumnoEqu');
    Route::get('avisoAlumnoAgregado', 'ControllerAlumnos@avisoAlumnoAgregado')->name('avisoAlumnoAgregado');
    Route::get('listarAlumnos/{clave_grupo}/{rvoe}/{vigencia}', 'ControllerGrupo@listarAlumnos')->name('listarAlumnos');
    Route::get('editarAlumno/{curp}/{clave_grupo}', 'ControllerAlumnos@editar_datos')->name('editarAlumno');
    Route::get('editarAlumn', 'ControllerAlumnos@editar_datos')->name('editarAlu');
    //Route::put('actualizar_alumno/{matricula}','ControllerAlumnos@actualizar_datos')->name('editarA/{matricula}');
    Route::post('actualizar_alumno/{matricula}', 'ControllerAlumnos@actualizar_datos')->name('editarAlum');
    Route::get('formGroup/{rvoe}/{vigencia}', 'ControllerGrupo@ver_formularioGrupo')->name('formGroup');
    Route::get('alumnosCalificacion/{clave_grupo}/{rvoe}/{vigencia}', 'ControllerGrupo@listarAlumnosCalificacion')->name('alumnosCalificacion');

    Route::get('alumnosRepro/{clave_grupo}/{rvoe}/{vigencia}', 'ControllerGrupo@listarAlumnosRepro')->name('alumnosRepro');
    Route::post('materiasNoOrdinario', 'ControllerMateria@materiasNoOrdinario')->name('materiasNoOrdinario');
    ///
    Route::get('formularioGrupo/{rvoe}/{vigencia}', 'ControllerGrupo@ver_formularioGrupo')->name('formularioGrupo')->middleware('auth');
    Route::post('insertarGrupo/{rvoe}/{vigencia}', 'ControllerGrupo@insertarGrupo')->name('registroGrupo');
    Route::get('avisoGrupoAgregado/{rvoe}/{vigencia}', 'ControllerGrupo@avisoGrupoAgregado')->name('avisoGrupoAgregado');
    Route::get('verGrupos/{rvoe}/{vigencia}', 'ControllerGrupo@listaGrupo')->name('verGrupos');
    Route::get('agregarDocente', 'ControllerDocente@formDocente')->name('agregarDocente');
    Route::get('listarPlan', 'PlanEstudioController@listarPlanes')->name('listarPlan')->middleware('auth');
    Route::get('listarPlanGrupo', 'PlanEstudioController@planesPorInsitucion')->name('listarPlanGrupo');
    Route::get('perfilPlan/{rvoe}/{vigencia}', 'CtrlEscolarController@perfilPlanes')->name('perfilPlan');
    Route::get('editarFormGrupo/{rvoe}/{clave_grupo}/{vigencia}', 'ControllerGrupo@formEditarGrupo')->name('editarFormGrupo');
    Route::post('editarGrupo/{rvoe}/{vigencia}', 'ControllerGrupo@editarGrupo')->name('editarGrupo');
    Route::post('eliminarGrupo/{clave_grupo}/{rvoe}/{vigencia}', 'ControllerGrupo@eliminarGrupo')->name('eliminarGrupo');
    Route::get('listarDocentes', 'ControllerDocente@listarDocentes')->name('listarDocentes');
    Route::post('eliminarDocente/{rfc}/{clave_cct}', 'ControllerDocente@eliminarDocente')->name('eliminarDocente');
    Route::get('detallePControl/{rvoe}', 'PlanEstudioController@detallePlanControl')->name('detallePControl');
    Route::get('listMatCtrl/{rvoe}/{vigencia}', 'ControllerMateria@listMatCtrl')->name('listMatCtrl');
    Route::post('consultajax5', 'ControllerMateria@consultaAjax4')->name('consultajax5');
    Route::get('avance/{rvoe}/{vigencia}/{curp}/{clave_grupo}', 'ControllerMateria@viewConsAlu_asig')->name('avance');
    Route::post('cons', 'ControllerMateria@consultaAlu_Asig')->name('cons');
    Route::post('matAluGgpAsig', 'ControllerMateria@materiasAluGpoAsig')->name('matAluGgpAsig');
    Route::get('verGruposCalificar/{rvoe}/{vigencia}', 'ControllerGrupo@vistaGrupoCalificar')->name('verGruposCalificar');
    Route::get('alumnoAsignaturas/{rvoe}/{vigencia}/{curp}/{clave_grupo}', 'ControllerGrupo@alumnoverAsignaturasCa')->name('alumnoAsignaturas');
    Route::post('sendArray', 'ControllerAsignatura@calificar')->name('sendArray');
    Route::get('verGruposCalificarExtra/{rvoe}/{vigencia}', 'ControllerGrupo@vistaGrupoCalificarExtra')->name('verGruposCalificarExtra');
    Route::get('calificacionExtra/{rvoe}/{vigencia}/{curp}/{clave_grupo}', 'ControllerGrupo@calificacionNoOrdinaria')->name('calificacionExtra');
    Route::post('sendArrayRepro', 'ControllerAsignatura@sendArrayExtra')->name('sendArrayRepro');
    //Reinscripción
    Route::get('gruposReinscripcion/{rvoe}/{vigencia}', 'ControllerGrupo@vistaGruposReinscripción')->name('gruposReinscripcion');
    Route::get('califEquivalencias/{rvoe}/{vigencia}/{curp}/{clave_grupo}', 'ControllerMateria@asignarCalificacionEquivalencias')->name('califEquivalencias');
    Route::post('sendArrayEq', 'ControllerMateria@agregarCalificacionEqui')->name('sendArrayEq');
    Route::get('reinscripcionAlumnos/{clave_grupo}/{rvoe}/{vigencia}', 'ControllerGrupo@verAlumnosParaReinscripcion')->name('reinscripcionAlumnos');
    Route::post('cargaReinscripcion', 'ControllerGrupo@cargaReinscripcion')->name('cargaReinscripcion');
    Route::get('listaAlumnosReinscritos/{clave_grupo}/{rvoe}/{vigencia}', 'ControllerGrupo@listaAlumnosReinscritos')->name('listaAlumnosReinscritos');
    Route::get('cargaAsignaturasReinscripcion/{curp}/{rvoe}/{vigencia}/{clave_grupo}', 'ControllerGrupo@cargaAsignaturasReinscripcion')->name('cargaAsignaturasReinscripcion');
    Route::post('cargaAsignaturas', 'ControllerGrupo@cargaAsignaturasR')->name('cargaAsignaturas');
    Route::get('removerdegrupo/{curp}/{rvoe}/{vigencia}/{clave_grupo}','ControllerGrupo@removerAlumnoGrupo')->name('removerdegrupo');
    //baja Alumnos
    Route::get('gruposBajaAlumnos/{rvoe}/{vigencia}', 'ControllerGrupo@vistaGruposBajaAlumnos')->name('gruposBajaAlumnos');
    Route::get('listarAlumnosBaja/{clave_grupo}/{rvoe}/{vigencia}','ControllerGrupo@listarAlumnosBaja')->name('listarAlumnosBaja');
    Route::post('bajaAlumno','ControllerGrupo@bajaAlumno')->name('bajaAlumno');
});
//Rutas de Admin y Analista
Route::group(['middleware' => ['auth', 'EsAnalista', 'EsAdmin']], function () {
    //listado de planes por institucion desde administrador o analista

});

//Rutas de los 3 usuario
Route::group(['middleware' => ['auth']], function () {

    Route::get('perfil', 'ControllerUser@perfil')->name('perfil');
    Route::post('actualizar/{clave_usuario}', 'ControllerUser@update')->name('update');
    Route::post('updatePassword', 'ControllerUser@updatePassword')->name('updatePassword');
    Route::get('panel', 'ControllerUser@regresarPanel')->name('panel');
    Route::post('data', 'HomeController@data')->name('data');
});

Route::get('formExcel/{rvoe}/{vigencia}', 'ControllerAlumnos@vistaImportExcel')->name('formExcel')->middleware('auth');
Route::post('importExcel', 'ControllerAlumnos@import2')->name('importExcel');
/*DB::listen(function ($query) {
    echo "<pre> <span class='badge badge-danger'>{$query->sql}</span></pre>";
});*/
Route::get('noAutorizado', 'HomeController@acceso')->name('noAutorizado');
Route::get('aviso', 'HomeController@aviso')->name('aviso');


/*Route::get('perfilSU', 'AnalistaController@perfil')->name('perfilSU');*/

Route::get('sesionFallida', 'HomeController@sesion')->name('sesionFallida');
Route::get('/', 'HomeController@index');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('loginAdmin', 'Auth\LoginController@showLoginFormAdmin')->name('loginAdmin');
Route::get('loginAnalista', 'Auth\LoginController@showLoginFormAnalista')->name('loginAnalista');
//reseteo de contraseña
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendresetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::get('registroUsuario', 'Auth\RegisterController@showRegisterForm')->name('registroUsuario');
Route::get('registroAdmin', 'Auth\RegisterController@showRegisterFormAdmin')->name('registroAdmin');
Route::get('registroAnalista', 'Auth\RegisterController@showRegisterFormAnalista')->name('registroAnalista');
Route::post('registroUsuario', 'Auth\RegisterController@register')->name('registroUsuario');

Route::post('loginI', 'Auth\LoginController@login')->name('loginI');
//Route::get('/home', 'HomeController@index')->name('home');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
/*Route::get('datos', 'PlanEstudioController@eliminar_plan_estudios');*/

//Registro de Instituciones
/*Route::get('busquedaInstitucion', 'AnalistaController@busquedaInstitucion')->name('busIns');*/
/*Route::get('tabla', 'HomeController@tabla')->name('tabla');*/
// Formulario Alumnos



//Listado de asignaturas por plan de estudios
//
//Route::get('eliminarAlumno/{matricula}', 'ControllerAlumnos@editar_datos_eliminar')->name('eliminarAlumno/');
//Route::put('eliminar_alumno/{matricula}','ControllerAlumnos@eliminar_alumno')->name('eliminar_alumno/{matricula}');
//Route::get('eliminar_alumno/{matricula}', 'ControllerAlumnos@eliminar_alumno')->name('eliminar_alum/');
//Route::get('verInstitucion/{clave_cct}', 'ControllerInstitucion@perfilInstitucion')->name('verInstitucion');



//pruebas dinamico
//Route::get('CarrerasDinamico', 'ControllerCarreras@ver_CarrerasDinamico');
//Route::post('dynamic-field/insert', 'ControllerCarreras@insert')->name('dynamic-field.insert');

//Route::get('MateriasDinamico', 'ControllerMateria@ver_materiasDinamico');
//Route::post('dynamic-field1/insert', 'ControllerMateria@insert')->name('dynamic-field1.insert');

//Route::get('AlumnosDinamico', 'ControllerAlumnos@ver_alumnosDinamico');
//Route::post('dynamic-field2/insert', 'ControllerAlumnos@insert')->name('dynamic-field2.insert');

Route::get('InstitucionDinamico', 'ControllerInstitucion@ver_InstitucionesDinamico');

Route::get('InstitucionDinamico', 'ControllerInstitucion@ver_director2');
Route::post('dynamic-field/insert', 'ControllerInstitucion@insert')->name('dynamic-field.insert');


Route::get('DirectorDinamico', 'ControllerDirector@ver_DirectorDinamico');
Route::post('dynamic-field1/insert', 'ControllerDirector@insert')->name('dynamic-field1.insert');

Route::get('PlanDinamico', 'PlanEstudioController@ver_PlanDinamico');
Route::get('PlanDinamico', 'PlanEstudioController@ver_instituciones');
Route::post('dynamic-field5/insert', 'PlanEstudioController@insert')->name('dynamic-field5.insert');
//Route::post('dynamic-field/insert', 'ControllerInsPlan@insert')->name('dynamic-field6.insert');
//Route::post('dynamic-field6/insert', 'ControllerInsPlan@insert')->name('dynamic-field6.insert');


Route::get('AsignaturaDinamico', 'ControllerAsignatura@ver_AsigDinamico');
Route::get('AsignaturaDinamico', 'ControllerAsignatura@ver_plan');
Route::post('dynamic-field3/insert', 'ControllerAsignatura@insert')->name('dynamic-field3.insert');

//hoy
Route::get('GrupoDinamico', 'ControllerGrupo@ver_GpoDinamico');
Route::get('GrupoDinamico', 'ControllerGrupo@ver_asignaturas');
Route::post('dynamic-field4/insert', 'ControllerGrupo@insert')->name('dynamic-field4.insert');

//Route::get('GrupoDinamico', 'ControllerGrupo@ver_docente');

Route::get('docente', 'ControllerGrupo@ver_docente');


Route::get('asignatura', 'ControllerGrupo@ver_asignaturas')->name('asignatura.nombre');
Route::post('dynamic-field4/insert', 'ControllerGrupo@insert')->name('dynamic-field4.insert');





Route::post('insertarDocente', 'ControllerDocente@agregarDocente')->name('insertarDocente')->middleware('auth');
Route::post('dynamic-field2/insert', 'ControllerDocente@insert')->name('dynamic-field2.insert');

Route::get('lista_escuelas/{escuela}', 'ControllerInsPlan@listado_inst');

Route::get('InsPlanDinamico', 'ControllerInsPlan@ver_IPDinamico');
Route::get('InsPlanDinamico', 'ControllerInsPlan@ver_instituciones');
Route::post('dynamic-field6/insert', 'ControllerInsPlan@insert')->name('dynamic-field6.insert');

//pruebas csv
Route::get('export', 'ControllerCSV@export')->name('export');
Route::get('csv_file', 'ControllerCSV@index');
Route::post('import', 'ControllerCSV@import')->name('import');


Route::get('nombresdir', 'PlanEstudioController@ver_ultima')->name('ultima');

Route::get('AlumnosDinamico', 'ControllerAlumnos@ver_alumnosDinamico');
Route::get('AlumnosDinamico', 'ControllerAlumnos@ver_grupo');
Route::post('dynamic-field6/insert', 'ControllerAlumnos@insert')->name('dynamic-field6.insert');

/*Route::get('DatosExcel', function () {
    return view('VistaExcel');
});*/

Route::get('InsertarEscuela', function () {
    return view('InsertarInstitucion');
});

//rutas de edicion de planes  
Route::get('editarPlanMSU/{clave_cct}/{rvoe}', 'PlanEstudioController@formEditarPlanMSU')->name('editarPlanMSU');
Route::post('updatePlanMSU/{rvoe}/{clave_cct}', 'PlanEstudioController@editar_plan_estudiosMSU')->name('updatePlanMSU');

Route::get('editarPlanCPT/{clave_cct}/{rvoe}', 'PlanEstudioController@formEditarPlanCPT')->name('editarPlanCPT');
Route::post('updatePlanCPT/{rvoe}/{clave_cct}', 'PlanEstudioController@editar_plan_estudiosCPT')->name('updatePlanCPT');
//esta creo que se repite arriba pero esta con clave plan, quitasela y haces push
Route::get('editarPlan/{clave_cct}/{rvoe}', 'PlanEstudioController@formEditarPlan')->name('editarPlan');
Route::post('updatePlan/{rvoe}/{clave_cct}', 'PlanEstudioController@editar_plan_estudios')->name('updatePlan');

Route::get('editPlanActu/{clave_cct}/{rvoe}/{vigencia}', 'PlanEstudioController@formEditPlanActu')->name('editPlanActu');
Route::post('updatePlanActu/{rvoe}/{clave_cct}/{vigencia}', 'PlanEstudioController@editar_plan_estudiosAct')->name('updatePlanActu');

Route::get('MateriasVariasSUP', 'ControllerMateria@ver_formularioVSUP')->name('MateriasVariasSUP');
Route::get('MateriasVariasSUP', 'ControllerMateria@ver_selectsVSUP1')->name('MateriasVariasSUP');
Route::post('insertarMateriaVSUP', 'ControllerMateria@inserMateriaVSUP')->name('registroMateriaVSUP');


Route::get('MateriasVariasMSU', 'ControllerMateria@ver_formularioVMSU')->name('MateriasVariasMSU');
Route::get('MateriasVariasMSU', 'ControllerMateria@ver_selectsVMSU')->name('MateriasVariasMSU');
Route::post('insertarMateriaVMSU', 'ControllerMateria@inserMateriaVMSU')->name('registroMateriaVMSU');

Route::get('MateriasVariasCPT', 'ControllerMateria@ver_formularioVCPT')->name('MateriasVariasCPT');
Route::get('MateriasVariasCPT', 'ControllerMateria@ver_selectsVCPT')->name('MateriasVariasCPT');
Route::post('insertarMateriaVCPT', 'ControllerMateria@inserMateriaVCPT')->name('registroMateriaVCPT');

Route::get('avisoMatVSUP', 'ControllerMateria@avisoVMat')->name('avisoMatVSUP');
Route::get('avisoMatVMSU', 'ControllerMateria@avisoVMatMSU')->name('avisoMatVMSU');
Route::get('avisoMatVCPT', 'ControllerMateria@avisoVMatCPT')->name('avisoMatVCPT');

Route::get('MateriasVariasSUPxD/{clave_cct}/{rvoe}', 'ControllerMateria@ver_selectsVSUP')->name('MateriasVariasSUPxD');
//Route::get('MateriasVariasSUPxD/{clave_cct}', 'ControllerMateria@xDD')->name('MateriasVariasSUPxD');
Route::get('clave_cct/{clave_cct}', 'ControllerMateria@getCCT');

Route::get('MateriasVariasSUPxD', 'ControllerMateria@ver_selectsVSUP')->name('MateriasVariasSUPxD');


Route::get('editarMatSup/{clave_cct}/{rvoe}/{clave_asignatura}', 'ControllerMateria@formEditarMat')->name('editarMatSup');
Route::post('updateMatSup/{clave_asignatura}/{rvoe}', 'ControllerMateria@editar_materia')->name('updateMatSup');

Route::get('editarMatMSU/{clave_cct}/{rvoe}/{clave_asignatura}', 'ControllerMateria@formEditarMatMSU')->name('editarMatMSU');
Route::post('updateMatMSU/{clave_asignatura}/{rvoe}', 'ControllerMateria@editar_materiaMSU')->name('updateMatMSU');

Route::get('editarMatCPT/{clave_cct}/{rvoe}/{clave_asignatura}', 'ControllerMateria@formEditarMatCPT')->name('editarMatCPT');
Route::post('updateMatCPT/{clave_asignatura}/{rvoe}', 'ControllerMateria@editar_materiaCPT')->name('updateMatCPT');

//<<<<<<< HEAD
Route::get('FormularioCalif', 'ControllerCalif@vistaCalif1')->name('FormularioCalif');
Route::get('Calificar', 'ControllerCalif@vistaCalif2')->name('Calificar');
Route::get('Calificaciones', 'ControllerCalif@vistaCalif3')->name('Calificaciones');

Route::get('backTo', 'ControllerUser@regresarAtras')->name('backTo');
//Route::get('FormularioCalif', 'ControllerCalif@ver_datos')->name('FormularioCalif');
//Route::post('insertarCalif', 'ControllerCalif@insertPlan')->name('registroCalif');
//Route::get('avisoCalif', 'ControllerCalif@avisoCalif')->name('avisoCalif');

/*Route::get('exportInstSup', 'ControllerCSV@exportSup')->name('exportInstSup');
Route::get('csv_file_sup', 'ControllerCSV@indexSup');
Route::post('importInstSup', 'ControllerCSV@importSup')->name('importInstSup');


Route::get('exportInstMSU', 'ControllerCSV@exportMSU')->name('exportInstMSU');
Route::get('csv_file_msu', 'ControllerCSV@indexMSU');
Route::post('importInstMSU', 'ControllerCSV@importMSU')->name('importInstMSU');

Route::get('exportInstCPT', 'ControllerCSV@exportCPT')->name('exportInstCPT');
Route::get('csv_file_cpt', 'ControllerCSV@indexCPT');
Route::post('importInstCPT', 'ControllerCSV@importCPT')->name('importInstCPT');
=======*/
/*Route::get('FormularioCalif', 'ControllerCalif@ver_formCalif')->name('FormularioCalif');
   // Route::get('FormularioCalif', 'ControllerCalif@ver_datos')->name('FormularioCalif');
    Route::post('insertarCalif', 'ControllerCalif@insertPlan')->name('registroCalif');
    Route::get('avisoCalif', 'ControllerCalif@avisoCalif')->name('avisoCalif');
//>>>>>>> ff77cdfd4d9bf50c61ab338e8929c900d19a5ef1*/

Route::get('pruebaLayout', 'HomeController@pruebaLayout')->name('pruebaLayout');
Route::post('consultajax3', 'AdministradorController@consultaAjax3')->name('consultajax3');
Route::get('documentoValido/{clave_cct}/{rvoe}/{vigencia}/{clave_grupo}', 'HomeController@documentoValido')->name('documentoValido');
