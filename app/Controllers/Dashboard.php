<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\DoctorModel;
use App\Models\ObatModel;
use App\Models\PasienModel;
use App\Models\KunjunganModel;
use App\Models\ResepObatModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CodeIgniter\Pager\Pager;
use Dompdf\Dompdf;
use Dompdf\Options;

class Dashboard extends Controller
{
    // Fungsi untuk menampilkan dashboard utama
    public function index()
    {
        $doctorModel = new DoctorModel();
        $obatModel = new ObatModel();
        $pasienModel = new PasienModel();
        $kunjunganModel = new KunjunganModel();

        // Get total counts
        $totalDoctors = $doctorModel->countAllResults();
        $totalObat = $obatModel->countAllResults();
        $totalPasien = $pasienModel->countAllResults();

        // Get today's visits
        $today = date('Y-m-d');
        $todayVisits = $kunjunganModel->countAllResults();

        // Get recent activities
        // Assuming you have a method to get recent activities; modify as needed
        $recentActivities = $this->getRecentActivities();
        

        // Prepare data for the view
        $data = [
            'totalDoctors' => $totalDoctors,
            'totalObat' => $totalObat,
            'totalPasien' => $totalPasien,
            'todayVisits' => $todayVisits,
            'recentActivities' => $recentActivities,
        ];

        // Load the view with data
        return view('layouts/dashboard', $data);
    }

    private function getRecentActivities()
    {
        // Placeholder method; replace with your logic to fetch recent activities
        return [
            'Pasien A melakukan kunjungan pada 14/08/2024',
            'Dokter B menambahkan resep untuk pasien C',
            'Pasien D mendaftar untuk konsultasi',
        ];
    }
    

    public function logout()
    {
        // Destroy the session
        session()->destroy();

        // Redirect to the login page
        return redirect()->to('/login');
    }

    // Pengguna
    public function users()
    {
        $model = new UserModel(); // Initialize your model
    
        // Retrieve the search query from the request
        $search = $this->request->getGet('search');
    
        // Fetch paginated results based on search query
        if ($search) {
            $data['users'] = $model->like('username', $search)->paginate(10);
        } else {
            $data['users'] = $model->paginate(5);
        }
    
        $data['pager'] = $model->pager;
        $data['search'] = $search;
    
        return view('users', $data);
    }

    public function addUser()
    {
        return view('tambahuser');
    }

    public function storeUser()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'matches[password]'
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            // Validation failed, return to form with errors
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }
        
        $model = new \App\Models\UserModel();
    
        $data = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
        ];
        
        // Debugging
        log_message('debug', 'User Data: ' . print_r($data, true));
        
        if ($model->insert($data)) {
            return redirect()->to(site_url('dashboard/users'))->with('success', 'User added successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to add user.');
        }
    }
    

    public function editUser($id)
    {
        $userModel = new UserModel();
        $data['user'] = $userModel->find($id);
        return view('editusers', $data);
    }
    

    public function updateUser()
    {
        $userModel = new UserModel();
        $id = $this->request->getPost('id');
        $data = [
            'username' => $this->request->getPost('username'),
            'password' => md5($this->request->getPost('password')), // Hashing password
        ];  
        $userModel->update($id, $data);
        return redirect()->to('/dashboard/users');
    }

    public function deleteUser($id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);
        return redirect()->to('/dashboard/users');
    }

    // Dokter
    public function doctors()
{
    $model = new DoctorModel(); // Initialize your model

    // Retrieve the search query from the request
    $search = $this->request->getGet('search');

    // Fetch paginated results based on search query
    if ($search) {
        $data['doctors'] = $model->like('nama_dokter', $search)->paginate(10);
    } else {
        $data['doctors'] = $model->paginate(5);
    }

    $data['pager'] = $model->pager;
    $data['search'] = $search;

    return view('dokter', $data);
}


    public function addDoctor()
    {
        return view('tambahdokter');
    }

    public function createDoctor()
    {
        $doctorModel = new DoctorModel();
        $data = [
            'nama_dokter' => $this->request->getPost('nama_dokter'),
        ];
        $doctorModel->insert($data);
        return redirect()->to('/dashboard/doctors');
    }

    public function editDoctor($id)
    {
        $doctorModel = new DoctorModel();
        $data['doctor'] = $doctorModel->find($id);
        return view('editdokter', $data);
    }

    public function updateDoctor()
    {
        $doctorModel = new DoctorModel();
        $id = $this->request->getPost('id_dokter');
        $data = [
            'nama_dokter' => $this->request->getPost('nama_dokter'),
        ];
        $doctorModel->update($id, $data);
        return redirect()->to('/dashboard/doctors');
    }

    public function deleteDoctor($id)
    {
        $doctorModel = new DoctorModel();
        $doctorModel->delete($id);
        return redirect()->to('/dashboard/doctors');
    }
    

    public function medications()
    {
        $model = new ObatModel(); // Initialize your model
    
        // Retrieve the search query from the request
        $search = $this->request->getGet('search');
    
        // Fetch paginated results based on search query
        if ($search) {
            $data['obats'] = $model->like('nama_obat', $search)->paginate(1);
        } else {
            $data['obats'] = $model->paginate(5);
        }
    
        $data['pager'] = $model->pager;
        $data['search'] = $search;
    
        return view('obat', $data);
    }

    public function addMedication()
    {
        return view('tambahobat');
    }


    public function createMedication()
    {
        $obatModel = new ObatModel();
        $data = [
            'nama_obat' => $this->request->getPost('nama_obat'),
        ];
        $obatModel->insert($data);
        return redirect()->to('/dashboard/medications');
    }

    public function editMedication($id)
    {
        $obatModel = new ObatModel();
        $data['obat'] = $obatModel->find($id);
        return view('editobat', $data);
    }

    public function updateMedication()
    {
        $obatModel = new ObatModel();
        $id = $this->request->getPost('id_obat');
        $data = [
            'nama_obat' => $this->request->getPost('nama_obat'),
        ];
        $obatModel->update($id, $data);
        return redirect()->to('/dashboard/medications');
    }

    public function deleteMedication($id)
    {
        $obatModel = new ObatModel();
        $obatModel->delete($id);
        return redirect()->to('/dashboard/medications');
    }

    // Pasien
    public function patient()
    {
        $model = new PasienModel();

        // Handle search query
        $search = $this->request->getGet('search');

        if ($search) {
            $data['pasien'] = $model->like('nama_pasien', $search)->paginate(4);
        } else {
            $data['pasien'] = $model->paginate(5);
        }

        $data['pager'] = $model->pager;
        $data['search'] = $search;

        return view('pasien', $data);
    }

    public function createPatient()
    {
        return view('tambahpasien');
    }

    public function storePatient()
    {
        $model = new PasienModel();
        $data = [
            'nama_pasien' => $this->request->getPost('nama_pasien'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'umur' => $this->request->getPost('umur')
        ];
        if ($model->save($data)) {
            return redirect()->to('dashboard/patient');
        } else {
            return redirect()->back()->with('errors', $model->errors());
        }
    }

    public function editPatient($id_pasien)
    {
        $model = new PasienModel();
        $data['pasien'] = $model->find($id_pasien);
        return view('editpasien', $data);
    }

    public function updatePatient($id_pasien)
    {
        $model = new PasienModel();
        $data = [
            'nama_pasien' => $this->request->getPost('nama_pasien'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'umur' => $this->request->getPost('umur')
        ];
        if ($model->update($id_pasien, $data)) {
            return redirect()->to('dashboard/patient');
        } else {
            return redirect()->back()->with('errors', $model->errors());
        }
    }

    public function deletePatient($id)
{
    $kunjunganModel = new KunjunganModel();
    $kunjunganModel->where('id_pasien', $id)->delete();
    
    $model = new PasienModel();
    $model->delete($id);
    
    return redirect()->to('dashboard/patient');
}


    // Kunjungan
  public function visits()
{
    $search = $this->request->getGet('search');
    $currentPage = $this->request->getGet('page') ?? 1;

    $kunjunganModel = new KunjunganModel();
    $doctorModel = new DoctorModel();
    $pasienModel = new PasienModel();

    // Define the pagination limit
    $limit = 5;

    // Build query with search filter
    if ($search) {
        // Join pasien table to filter by patient's name
        $kunjunganModel->join('pasien', 'kunjungan.id_pasien = pasien.id_pasien');
        $kunjunganModel->like('pasien.nama_pasien', $search); // Filtering by patient's name
    }

    // Set pagination config
    $pager = \Config\Services::pager();

    // Get paginated results
    $data['kunjungans'] = $kunjunganModel->paginate($limit, 'default', $currentPage);
    $data['pager'] = $kunjunganModel->pager; // Link pagination object to the model's pager

    // Fetch all doctors and patients
    $doctors = $doctorModel->findAll();
    $patients = $pasienModel->findAll();

    // Convert doctor and patient data for easy access
    $data['doctors'] = array_column($doctors, 'nama_dokter', 'id_dokter');
    $data['patients'] = array_column($patients, null, 'id_pasien');

    // Pass the search query to the view
    $data['search'] = $search;

    // Load the view
    return view('kunjungan', $data);
}

    

    public function addVisit()
    {
        $doctorModel = new DoctorModel();
        $pasienModel = new PasienModel();

        $data['doctors'] = $doctorModel->findAll();
        $data['patients'] = $pasienModel->findAll();

        return view('tambahkunjungan', $data);
    }

    public function createVisit()
    {
        $kunjunganModel = new KunjunganModel();
        $doctorModel = new DoctorModel();
        $pasienModel = new PasienModel();
        
        $id_dokter = $this->request->getPost('id_dokter');
        $id_pasien = $this->request->getPost('id_pasien');
        $tgl_berobat = $this->request->getPost('tgl_berobat');
        
        // Validate form inputs
        if (!$this->validate([
            'id_dokter' => 'required',
            'id_pasien' => 'required',
            'tgl_berobat' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Please fill out all required fields.');
        }
    
        // Check if doctor exists
        $doctor = $doctorModel->find($id_dokter);
        if (!$doctor) {
            return redirect()->back()->with('error', 'Invalid doctor selected');
        }
    
        $data = [
            'id_dokter' => $id_dokter,
            'id_pasien' => $id_pasien,
            'tgl_berobat' => $tgl_berobat,
            // Add other necessary fields here
        ];
    
        // Insert the visit data
        $kunjunganModel->insert($data);
    
        // Redirect to the visits page
        return redirect()->to('/dashboard/visits')->with('success', 'Visit created successfully.');
    }
    
    

    public function editVisit($id_berobat)
    {
        $kunjunganModel = new KunjunganModel();
        $doctorModel = new DoctorModel();
        $pasienModel = new PasienModel();

        $data['kunjungan'] = $kunjunganModel->find($id_berobat);
        $data['doctors'] = $doctorModel->findAll();
        $data['patients'] = $pasienModel->findAll();

        return view('editkunjungan', $data);
    }

    public function updateVisit()
    {
        $kunjunganModel = new KunjunganModel();
        $id_berobat = $this->request->getPost('id_berobat');
        $data = [
            'id_pasien' => $this->request->getPost('id_pasien'),
            'id_dokter' => $this->request->getPost('id_dokter'),
            'tgl_berobat' => $this->request->getPost('tgl_berobat'),
            'keluhan_pasien' => $this->request->getPost('keluhan_pasien'),
            'hasil_diagnosa' => $this->request->getPost('hasil_diagnosa'),
            'penatalaksanaan' => $this->request->getPost('penatalaksanaan'),
        ];
        

        $kunjunganModel->update($id_berobat, $data);
        return redirect()->to('/dashboard/visits');
    }

    public function deleteVisit($id_berobat)
    {
        $kunjunganModel = new KunjunganModel();
        $kunjunganModel->delete($id_berobat);
        return redirect()->to('/dashboard/visits');
    }

    public function addPrescription($id_berobat)
{
    $resepObatModel = new \App\Models\ResepObatModel();
    
    // Retrieve the submitted data from the form
    $data = [
        'id_obat'   => $this->request->getPost('id_obat'),
        'jumlah'    => $this->request->getPost('jumlah'),
        'id_berobat' => $id_berobat // Link prescription to the correct visit
    ];
    
    // Insert the prescription data into the database
    $resepObatModel->insert($data);
    
    // Redirect back to the paginated medical record page to show updated data
    // Assuming you need to pass page number if present
    $page = $this->request->getPost('page') ?: 1;
    return redirect()->to('/dashboard/visits/medical_record/' . $id_berobat . '?page=' . $page);
}

    
    public function delete($id)
    {
        $resepObatModel = new ResepObatModel();
    
        // Retrieve the ID of the visit (kunjungan) associated with the prescription
        $resep = $resepObatModel->find($id);
        if (!$resep) {
            return redirect()->back()->with('error', 'Resep obat tidak ditemukan');
        }
    
        $id_berobat = $resep['id_berobat'];
    
        // Attempt to delete the prescription
        if ($resepObatModel->delete($id) === false) {
            return redirect()->to('/dashboard/visits/medical_record/'.$id_berobat)->with('error', 'Failed to delete data.');
        }
    
        return redirect()->to('/dashboard/visits/medical_record/'.$id_berobat)->with('success', 'Data deleted successfully.');
    }
    
    
    
    public function medicalRecord($id_berobat)
    {
        // Load the required models
        $kunjunganModel = new KunjunganModel();
        $pasienModel = new PasienModel();
        $obatModel = new ObatModel();
        $resepObatModel = new ResepObatModel();
    
        // Fetch kunjungan (visit) data based on the ID
        $kunjungan = $kunjunganModel->find($id_berobat);
        if (!$kunjungan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kunjungan tidak ditemukan');
        }
    
        // Fetch pasien (patient) data using the patient ID from the kunjungan data
        $pasien = $pasienModel->find($kunjungan['id_pasien']);
        if (!$pasien) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pasien tidak ditemukan');
        }
    
        // Fetch the patient's medical history (riwayat berobat)
        $riwayat = $kunjunganModel->where('id_pasien', $kunjungan['id_pasien'])->findAll();
    
        // Fetch the patient's medical records (catatan rekam medis)
        $catatan = $kunjunganModel->where('id_pasien', $kunjungan['id_pasien'])->findAll();
    
        // Fetch all medications for the dropdown
        $obat_dropdown = [];
        foreach ($obatModel->findAll() as $obat) {
            $obat_dropdown[$obat['id_obat']] = $obat['nama_obat'];
        }
    
        // Pagination setup for prescriptions
        $pager = \Config\Services::pager();
        $perPage = 1; // Number of items per page
        $currentPage = $this->request->getGet('page') ?: 1;
    
        // Fetch paginated prescriptions for this visit
        $resep_obat = $resepObatModel
            ->join('obat', 'obat.id_obat = resep_obat.id_obat')
            ->where('resep_obat.id_berobat', $id_berobat)
            ->paginate($perPage, 'default', $currentPage);
    
        // Prepare the data for the view
        $data = [
            'kunjungan' => $kunjungan,
            'pasien'    => $pasien,
            'riwayat'   => $riwayat,
            'catatan'   => $catatan,
            'obat_dropdown' => $obat_dropdown,
            'resep_obat' => $resep_obat, // Send paginated prescription data to the view
            'pager'     => $pager,      // Pass pager to view for pagination links
            'id_berobat' => $id_berobat  // Pass visit ID to view
        ];
    
        // Return the view with the prepared data
        return view('rekammedis', $data);
    }
    
    

public function updateNote()
{
    $id_berobat = $this->request->getPost('id_berobat');

    if (!$id_berobat) {
        throw new \Exception('ID tidak disediakan untuk pembaruan');
    }

    $kunjunganModel = new KunjunganModel();
    $data = [
        'keluhan_pasien' => $this->request->getPost('keluhan_pasien'),
        'hasil_diagnosa' => $this->request->getPost('hasil_diagnosa'),
        'penatalaksanaan' => $this->request->getPost('penatalaksanaan'),
    ];

    $kunjunganModel->update($id_berobat, $data);
    return redirect()->to('/dashboard/visits/medical_record/'.$id_berobat);
}

public function medicationsobat()
{
    $obatModel = new ObatModel();
    $data['obats'] = $obatModel->findAll(); // Mengambil semua data obat

    return view('kunjungan', $data); // Mengirim data ke view medications
}


public function reportDoctors()
    {
        $doctorModel = new DoctorModel();

        // Ambil data dokter
        $doctors = $doctorModel->findAll();

        // Kirim data dokter ke view
        $data = [
            'doctors' => $doctors,
        ];

        return view('laporandokter', $data);
    }

    public function reportPatients()
    {
        $patientModel = new PasienModel();
        $data['patients'] = $patientModel->findAll();

        return view('laporanpasien', $data);
    }


    public function reportVisits()
{
    // Load the models
    $kunjunganModel = new KunjunganModel();
    $doctorModel = new DoctorModel();
    
    // Fetch the list of doctors (if needed for dropdowns or filters)
    $doctors = $doctorModel->findAll();
    
    // Get the search term and date range from the request
    $searchTerm = $this->request->getGet('search') ?? '';
    $startDate = $this->request->getGet('start_date');
    $endDate = $this->request->getGet('end_date');
    
    // Pagination settings
    $limit = 5; // Number of records per page
    $currentPage = $this->request->getVar('page') ?? 1;
    
    // Build the query
    $kunjunganBuilder = $kunjunganModel->select('kunjungan.id_berobat, kunjungan.tgl_berobat, pasien.nama_pasien, pasien.jenis_kelamin, pasien.umur, kunjungan.keluhan_pasien, kunjungan.hasil_diagnosa')
                                       ->join('pasien', 'kunjungan.id_pasien = pasien.id_pasien');
    
    // Apply search filter if a search term is provided
    if (!empty($searchTerm)) {
        $kunjunganBuilder->groupStart() // Start grouping conditions
                         ->like('pasien.nama_pasien', $searchTerm)
                         ->orLike('kunjungan.tgl_berobat', $searchTerm)
                         ->groupEnd(); // End grouping conditions
    }
    
    // Apply date range filter if start and end dates are provided
    if ($startDate && $endDate) {
        $kunjunganBuilder->where('kunjungan.tgl_berobat >=', $startDate)
                         ->where('kunjungan.tgl_berobat <=', $endDate);
    }
    
    // Fetch paginated visit data
    $kunjungans = $kunjunganBuilder->paginate($limit, 'default', $currentPage);
    
    // Prepare data to pass to the view
    $data = [
        'doctors' => $doctors,
        'kunjungans' => $kunjungans,
        'pager' => $kunjunganModel->pager,
        'currentPage' => $currentPage,
        'searchTerm' => $searchTerm,
        'startDate' => $startDate,
        'endDate' => $endDate
    ];
    
    // Load the view and pass the data
    return view('laporankunjungan', $data);
}

    


    public function exportDoctorsToExcel()
    {
        $doctorModel = new DoctorModel();
        $doctors = $doctorModel->findAll();
        

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header
        $sheet->setCellValue('A1', 'ID Dokter');
        $sheet->setCellValue('B1', 'Nama Dokter');

        // Isi data dokter
        $row = 2;
        $no = 1;
        foreach ($doctors as $doctor) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $doctor['nama_dokter']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'data_dokter.xlsx';

        // Set header untuk file Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }
    public function exportPatientsToExcel()
    {
        // Load patient data from the database
        $PasienModel = new PasienModel();
        $patients = $PasienModel->findAll();
    
        // Create a new Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Set the header for the Excel file
        $sheet->setCellValue('A1', 'ID Pasien');
        $sheet->setCellValue('B1', 'Nama Pasien');
        $sheet->setCellValue('C1', 'Jenis Kelamin');
        $sheet->setCellValue('D1', 'Umur');
    
        // Populate the data
        $row = 2; // Mulai dari baris kedua karena baris pertama digunakan untuk header

        // Populate the data
        $no = 1; // Inisialisasi nomor urut
        foreach ($patients as $patient) {
            $sheet->setCellValue('A' . $row, $no++); // Gunakan $no untuk nomor urut
            $sheet->setCellValue('B' . $row, $patient['nama_pasien']);
            $sheet->setCellValue('C' . $row, $patient['jenis_kelamin']);
            $sheet->setCellValue('D' . $row, $patient['umur']);
            $row++;
        }

    
        // Create the writer and output the file
        $writer = new Xlsx($spreadsheet);
        $filename = 'patient_data.xlsx';
    
        // Redirect output to a client’s web browser (Excel)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
    
        $writer->save('php://output');
        exit;
    }
    public function exportMedicationsToExcel()
{
    // Load medication data from the database
    $ObatModel = new ObatModel();
    $medications = $ObatModel->findAll();

    // Create a new Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set the header for the Excel file
    $sheet->setCellValue('A1', 'ID Obat');
    $sheet->setCellValue('B1', 'Nama Obat');

    // Populate the data
    $row = 2;

    $no = 1;
    foreach ($medications as $medication) {
        $sheet->setCellValue('A' . $row, $no++);
        $sheet->setCellValue('B' . $row, $medication['nama_obat']);
        $row++;
    }

    // Create the writer and output the file
    $writer = new Xlsx($spreadsheet);
    $filename = 'medication_data.xlsx';

    // Redirect output to a client’s web browser (Excel)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
}
public function exportVisitsToExcel()
{
    // Load PhpSpreadsheet library
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Fetch visits data from the model
    $visitsModel = new \App\Models\KunjunganModel(); // Ensure this model exists
    $visits = $visitsModel->findAll(); // or a custom method to get data

    // Fetch patient data
    $patientsModel = new \App\Models\PasienModel(); // Ensure this model exists
    $patients = $patientsModel->findAll(); // or a custom method to get patient data

    // Create a map of patient IDs to patient details
    $patientMap = [];
    foreach ($patients as $patient) {
        $patientMap[$patient['id_pasien']] = [
            'nama_pasien' => $patient['nama_pasien'],
            'jenis_kelamin' => $patient['jenis_kelamin'],
            'umur' => $patient['umur']
        ];
    }

    // Add header
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Tgl Kunjungan');
    $sheet->setCellValue('C1', 'Nama Pasien');
    $sheet->setCellValue('D1', 'L/P');
    $sheet->setCellValue('E1', 'Umur');
    $sheet->setCellValue('F1', 'Keluhan');
    $sheet->setCellValue('G1', 'Diagnosa');

    // Populate the data
    $row = 2;
    foreach ($visits as $index => $visit) {
        $patientDetails = isset($patientMap[$visit['id_pasien']]) ? $patientMap[$visit['id_pasien']] : [
            'nama_pasien' => 'Unknown',
            'jenis_kelamin' => 'Unknown',
            'umur' => 'Unknown'
        ];
        
        $sheet->setCellValue('A' . $row, $index + 1);
        $sheet->setCellValue('B' . $row, $visit['tgl_berobat']);
        $sheet->setCellValue('C' . $row, $patientDetails['nama_pasien']);
        $sheet->setCellValue('D' . $row, $patientDetails['jenis_kelamin']);
        $sheet->setCellValue('E' . $row, $patientDetails['umur']);
        $sheet->setCellValue('F' . $row, $visit['keluhan_pasien']);
        $sheet->setCellValue('G' . $row, $visit['hasil_diagnosa']);
        $row++;
    }

    // Save the file
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $exportPath = WRITEPATH . 'exports/';
    if (!is_dir($exportPath)) {
        mkdir($exportPath, 0777, true);
    }
    $fileName = 'Laporan_Kunjungan_' . date('Y-m-d') . '.xlsx';
    $filePath = $exportPath . $fileName;
    
    $writer->save($filePath);

    // Download the file
    return $this->response->download($filePath, null)->setFileName($fileName);
}

public function exportPatientVisitsToExcel($id_pasien)
{
    // Load required libraries
    helper('excel'); // Assuming you have an Excel helper or library loaded

    // Load the model
    $kunjunganModel = new KunjunganModel();

    // Fetch patient visits data
    $patientVisits = $kunjunganModel->select('kunjungan.tgl_berobat, pasien.nama_pasien, pasien.jenis_kelamin, pasien.umur, kunjungan.keluhan_pasien, kunjungan.hasil_diagnosa')
                                    ->join('pasien', 'kunjungan.id_pasien = pasien.id_pasien')
                                    ->where('kunjungan.id_pasien', $id_pasien)
                                    ->findAll();

    // Create new Excel document
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set the headers
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Tanggal Berobat');
    $sheet->setCellValue('C1', 'Nama Pasien');
    $sheet->setCellValue('D1', 'Jenis Kelamin');
    $sheet->setCellValue('E1', 'Umur');
    $sheet->setCellValue('F1', 'Keluhan');
    $sheet->setCellValue('G1', 'Diagnosa');

    // Populate the data
    $row = 2;
    $no = 1;
    foreach ($patientVisits as $visit) {
        $sheet->setCellValue('A' . $row, $no++);
        $sheet->setCellValue('B' . $row, $visit['tgl_berobat']);
        $sheet->setCellValue('C' . $row, $visit['nama_pasien']);
        $sheet->setCellValue('D' . $row, $visit['jenis_kelamin']);
        $sheet->setCellValue('E' . $row, $visit['umur']);
        $sheet->setCellValue('F' . $row, $visit['keluhan_pasien']);
        $sheet->setCellValue('G' . $row, $visit['hasil_diagnosa']);
        $row++;
    }

    // Save and download the Excel file
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $filename = 'PatientVisits.xlsx';
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    
    $writer->save('php://output');
    exit();
}


public function doctorsPdf()
    {
        $doctorModel = new DoctorModel();
        $doctor = $doctorModel->findAll();

        // Load the HTML content for the PDF
        $html = view('doctors_pdf', ['doctors' => $doctor]);

        // Instantiate Dompdf with options
        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $dompdf = new Dompdf($options);

        // Load the HTML content into Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('DoctorsList.pdf', array("Attachment" => false));
    }

    public function exportPatientsToPdf()
{
    $pasienModel = new PasienModel();
    $pasien = $pasienModel->findAll();

    $data = [
        'pasien' => $pasien,
    ];

    $html = view('patients_pdf', $data);

    // Load PDF library (dompdf)
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("data_pasien.pdf", ["Attachment" => 0]);
}
public function exportMedicationsToPdf()
{
    $obatModel = new ObatModel();
    $obats = $obatModel->findAll();

    $data = [
        'obats' => $obats,
    ];

    // Load the view as HTML
    $html = view('medications_pdf', $data);

    // Initialize Dompdf
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Output the generated PDF (0 = open in browser, 1 = download)
    $dompdf->stream("data_obat.pdf", ["Attachment" => 0]);
}

public function exportVisitsToPdf()
{
    // Fetch data with a join to include 'nama_pasien', 'jenis_kelamin', and 'umur' from the 'pasien' table
    $kunjunganModel = new KunjunganModel();
    $kunjungans = $kunjunganModel->select('kunjungan.*, pasien.nama_pasien, pasien.jenis_kelamin, pasien.umur')
                                 ->join('pasien', 'kunjungan.id_pasien = pasien.id_pasien')
                                 ->findAll();

    $data = [
        'kunjungans' => $kunjungans,
    ];

    // Load the view as HTML
    $html = view('report_visits_pdf', $data);

    // Initialize Dompdf
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Output the generated PDF (0 = open in browser, 1 = download)
    $dompdf->stream("laporan_kunjungan.pdf", ["Attachment" => 0]);
}

public function viewPrescriptions($id_berobat)
{
    $resepModel = new \App\Models\ResepObatModel();
    $pager = \Config\Services::pager();

    // Pagination setup
    $perPage = 4; // Number of items per page
    $currentPage = $this->request->getGet('page') ? $this->request->getGet('page') : 1;

    // Get paginated data
    $prescriptions = $resepModel
        ->join('obat', 'obat.id_obat = resep_obat.id_obat')
        ->join('kunjungan', 'kunjungan.id_berobat = resep_obat.id_berobat')
        ->join('pasien', 'pasien.id_pasien = kunjungan.id_pasien')
        ->select('resep_obat.jumlah, obat.nama_obat, pasien.nama_pasien, pasien.umur')
        ->where('resep_obat.id_berobat', $id_berobat)
        ->paginate($perPage, 'default', $currentPage);

    // Group prescriptions by patient
    $groupedPrescriptions = [];
    foreach ($prescriptions as $prescription) {
        $patientName = $prescription['nama_pasien'];
        if (!isset($groupedPrescriptions[$patientName])) {
            $groupedPrescriptions[$patientName] = [
                'nama_pasien' => $prescription['nama_pasien'],
                'umur' => $prescription['umur'],
                'prescriptions' => []
            ];
        }
        $groupedPrescriptions[$patientName]['prescriptions'][] = $prescription;
    }

    // Debugging
    log_message('info', 'Prescriptions data: ' . print_r($prescriptions, true));
    log_message('info', 'Grouped prescriptions data: ' . print_r($groupedPrescriptions, true));

    // Pass grouped prescriptions data and pager to the view
    return view('laporan_berobat', [
        'groupedPrescriptions' => $groupedPrescriptions,
        'pager' => $pager,
        'id_berobat' => $id_berobat
    ]);
}


public function exportToExcel($id_berobat)
    {
        $resepModel = new ResepObatModel();
        $prescriptions = $resepModel
            ->join('obat', 'obat.id_obat = resep_obat.id_obat')
            ->join('kunjungan', 'kunjungan.id_berobat = resep_obat.id_berobat')
            ->join('pasien', 'pasien.id_pasien = kunjungan.id_pasien')
            ->select('resep_obat.jumlah, obat.nama_obat, pasien.nama_pasien, pasien.umur')
            ->where('resep_obat.id_berobat', $id_berobat)
            ->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'No')
              ->setCellValue('B1', 'Nama Pasien')
              ->setCellValue('C1', 'Umur')
              ->setCellValue('D1', 'Nama Obat')
              ->setCellValue('E1', 'Jumlah');

        $row = 2;
        foreach ($prescriptions as $index => $prescription) {
            $sheet->setCellValue('A' . $row, $index + 1)
                  ->setCellValue('B' . $row, $prescription['nama_pasien'])
                  ->setCellValue('C' . $row, $prescription['umur'])
                  ->setCellValue('D' . $row, $prescription['nama_obat'])
                  ->setCellValue('E' . $row, $prescription['jumlah']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'Prescriptions_' . date('Ymd') . '.xlsx';
        $filepath = WRITEPATH . 'exports/' . $filename;

        $writer->save($filepath);

        return $this->response->download($filepath, null)->setFileName($filename);
    }

    public function exportToPdf($id_berobat)
{
    $resepModel = new \App\Models\ResepObatModel();

    // Fetch prescriptions
    $prescriptions = $resepModel
        ->join('obat', 'obat.id_obat = resep_obat.id_obat')
        ->join('kunjungan', 'kunjungan.id_berobat = resep_obat.id_berobat')
        ->join('pasien', 'pasien.id_pasien = kunjungan.id_pasien')
        ->select('resep_obat.jumlah, obat.nama_obat, pasien.nama_pasien, pasien.umur')
        ->where('resep_obat.id_berobat', $id_berobat)
        ->findAll();

    // Group prescriptions by patient
    $groupedPrescriptions = [];
    foreach ($prescriptions as $prescription) {
        $patientName = $prescription['nama_pasien'];
        if (!isset($groupedPrescriptions[$patientName])) {
            $groupedPrescriptions[$patientName] = [
                'nama_pasien' => $prescription['nama_pasien'],
                'umur' => $prescription['umur'],
                'prescriptions' => []
            ];
        }
        $groupedPrescriptions[$patientName]['prescriptions'][] = $prescription;
    }

    // Load Dompdf
    $options = new \Dompdf\Options();
    $options->set('defaultFont', 'Arial');
    $dompdf = new \Dompdf\Dompdf($options);

    // Generate HTML content from view
    $view = view('pdf_prescriptions', ['groupedPrescriptions' => $groupedPrescriptions]);
    $dompdf->loadHtml($view);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to the browser
    $filename = 'prescriptions_' . $id_berobat . '.pdf';
    $dompdf->stream($filename, ['Attachment' => false]);
}


    }
