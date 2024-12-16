<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->get('/login', 'Auth::login');
 $routes->post('/auth/authenticate', 'Auth::authenticate');
 $routes->get('/dashboard', 'Dashboard::index');
 $routes->get('/dashboard/patients', 'Dashboard::patients');
 $routes->get('/logout', 'Auth::logout');
 $routes->get('/users', 'UserController::index');
 $routes->get('/dashboard/users', 'Dashboard::users');
 $routes->get('/dashboard/editUser/(:num)', 'Dashboard::editUser/$1');
$routes->post('/dashboard/updateUser', 'Dashboard::updateUser');
$routes->get('/dashboard/deleteUser/(:num)', 'Dashboard::deleteUser/$1');
$routes->get('/dashboard/addUser', 'Dashboard::addUser');
$routes->post('/dashboard/storeUser', 'Dashboard::storeUser');
$routes->get('dashboard/doctors', 'Dashboard::doctors');
$routes->get('dashboard/addDoctor', 'Dashboard::addDoctor');
$routes->post('dashboard/updateDoctor', 'Dashboard::updateDoctor');
$routes->get('dashboard/updateDoctor', 'Dashboard::updateDoctor');
$routes->post('dashboard/createDoctor', 'Dashboard::createDoctor');
$routes->get('dashboard/editDoctor/(:segment)', 'Dashboard::editDoctor/$1');
$routes->get('dashboard/deleteDoctor/(:segment)', 'Dashboard::deleteDoctor/$1');
$routes->get('dashboard/medications', 'Dashboard::medications');
$routes->get('dashboard/addMedication', 'Dashboard::addMedication');
$routes->post('dashboard/createMedication', 'Dashboard::createMedication');
$routes->get('dashboard/editMedication/(:segment)', 'Dashboard::editMedication/$1');
$routes->get('dashboard/deleteMedication/(:segment)', 'Dashboard::deleteMedication/$1');
$routes->post('dashboard/updateMedication', 'Dashboard::updateMedication');
$routes->get('dashboard/patient', 'Dashboard::patient');
$routes->get('dashboard/createPatient', 'Dashboard::createPatient');
$routes->post('dashboard/addPatient', 'Dashboard::storePatient');
$routes->get('dashboard/pasien/edit/(:num)', 'Dashboard::editPatient/$1');
$routes->post('dashboard/pasien/update/(:num)', 'Dashboard::updatePatient/$1');
$routes->get('/pasien/delete/(:num)', 'Dashboard::deletePatient/$1');
$routes->get('/dashboard/visits', 'Dashboard::visits');
$routes->get('/dashboard/visits/add', 'Dashboard::addVisit');
$routes->post('/dashboard/visits/create', 'Dashboard::createVisit');
$routes->get('/dashboard/visits/edit/(:num)', 'Dashboard::editVisit/$1');
$routes->post('/dashboard/visits/update', 'Dashboard::updateVisit');
$routes->get('/dashboard/visits/delete/(:num)', 'Dashboard::deleteVisit/$1');
$routes->get('/dashboard/visits/medical_record/(:num)', 'Dashboard::medicalRecord/$1');
$routes->post('/dashboard/visits/medical_record/(:num)', 'Dashboard::medicalRecord/$1');
$routes->get('dashboard/editNote/(:num)', 'Dashboard::editNote/$1');
$routes->post('dashboard/updateNote/(:num)', 'Dashboard::updateNote/$1');
$routes->get('dashboard/update', 'Dashboard::update');
$routes->get('dashboard/kunjungan', 'Dashboard::kunjungan');
$routes->post('dashboard/addPrescription', 'Dashboard::addPrescription');
$routes->post('dashboard/updateNote/', 'Dashboard::updateNote');
$routes->get('resep-obat', 'ResepObatController::index');
$routes->post('resep-obat/save', 'ResepObatController::save');
$routes->get('dashboard/reportDoctors', 'Dashboard::reportDoctors');
$routes->get('dashboard/reportPatients', 'Dashboard::reportPatients');
$routes->get('dashboard/reportVisits', 'Dashboard::reportVisits');
$routes->get('/logout', 'Auth::logout');
$routes->post('/logout', 'Auth::logout');
$routes->get('dashboard/report_visits', 'Dashboard::reportVisits');
$routes->get('/dashboard/exportDoctorsToExcel', 'Dashboard::exportDoctorsToExcel');
$routes->get('dashboard/exportPatientsToExcel', 'Dashboard::exportPatientsToExcel');
$routes->get('dashboard/exportMedicationsToExcel', 'Dashboard::exportMedicationsToExcel');
$routes->get('dashboard/exportVisitsToExcel', 'Dashboard::exportVisitsToExcel');
$routes->get('dashboard/exportPatientVisitsToExcel/(:num)', 'Dashboard::exportPatientVisitsToExcel/$1');
$routes->get('dashboard/resep_obat/(:num)', 'Dashboard::resepObat/$1');
$routes->post('dashboard/addPrescription', 'Dashboard::addPrescription');
$routes->get('dashboard/doctorsPdf', 'Dashboard::doctorsPdf');
$routes->get('dashboard/exportPatientsToPdf', 'Dashboard::exportPatientsToPdf');
$routes->get('dashboard/exportMedicationsToPdf', 'Dashboard::exportMedicationsToPdf');
$routes->get('dashboard/exportVisitsToPdf', 'Dashboard::exportVisitsToPdf');
$routes->post('dashboard/add_resep_obat', 'Dashboard::add_resep_obat');
$routes->post('dashboard/addPrescription/(:num)', 'Dashboard::addPrescription/$1');
$routes->post('dashboard/delete_resep_obat/(:num)', 'Dashboard::deleteResepObat/$1');
$routes->get('resep_obat/delete/(:num)', 'Dashboard::delete/$1');
$routes->post('resep_obat/delete/(:num)', 'Dashboard::delete/$1');
$routes->get('/dashboard/laporanBerobat', 'Dashboard::laporanBerobat');
$routes->get('dashboard/viewPrescriptions/(:num)', 'Dashboard::viewPrescriptions/$1');
$routes->get('dashboard/viewPrescriptions', 'Dashboard::viewPrescriptions');
$routes->get('dashboard/searchPrescriptions', 'Dashboard::searchPrescriptions');
$routes->get('dashboard/exportToExcel/(:num)', 'Dashboard::exportToExcel/$1');
$routes->get('dashboard/exportToPdf/(:num)', 'Dashboard::exportToPdf/$1');























