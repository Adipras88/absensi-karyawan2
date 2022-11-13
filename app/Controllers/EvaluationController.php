<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EvaluationJobResultsModel;
use App\Models\EvaluationModel;
use App\Models\JobModel;
use App\Models\UserModel;
use Config\Services;

class EvaluationController extends BaseController
{
    protected $evaluationModel, $userModel, $jobModel, $evaluationJobResultsModel;

    public function __construct()
    {
        $this->evaluationModel = new EvaluationModel();
        $this->userModel = new UserModel();
        $this->jobModel = new JobModel();
        $this->evaluationJobResultsModel = new EvaluationJobResultsModel();
        helper(['form']);

        if (session()->get('level') != "admin") {
            echo 'Access denied';
            exit;
        }
    }

    public function index()
    {
        $data = [
            'page' => 'evaluation',
            'evaluation' => $this->evaluationModel
                ->join('users', 'users.userId = evaluations.user_id')
                ->get()
                ->getResultArray()
        ];

        echo view('layouts/pages/admin/evaluation/index', $data);
    }

    public function create()
    {
        $dataUser = $this->userModel->findAll();
        $dataJob = $this->jobModel->findAll();
        $data = [
            'page' => 'evaluation',
            'user' => $dataUser,
            'job' => $dataJob,
            'validation' => Services::validation(),
        ];

        echo view('layouts/pages/admin/evaluation/create', $data);
    }

    public function createSave()
    {
        $rules = [
            'user_id' => 'required',
            'job_id' => 'required',
            'disiplin' => 'required',
            'loyalitas' => 'required',
            'kerjasama' => 'required',
            'perilaku' => 'required',
            'value_job_type' => 'required',
        ];

        if ($this->validate($rules)) {
            $data = [
                'user_id' => $this->request->getVar('user_id'),
                'disiplin' => $this->request->getVar('disiplin'),
                'loyalitas' => $this->request->getVar('loyalitas'),
                'kerjasama' => $this->request->getVar('kerjasama'),
                'perilaku' => $this->request->getVar('perilaku'),
                'total_sikap' => $this->request->getVar('total_sikap'),
                'total_percentage_sikap' => $this->request->getVar('total_percentage_sikap'),
                'total_working_result' => $this->request->getVar('total_working_result'),
                'total_percentage_working_result' => $this->request->getVar('total_percentage_working_result'),
                'total' => $this->request->getVar('totalNilai'),
                'predikat' => $this->request->getVar('predikat'),
                'evaluation_created' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $this->evaluationModel->save($data);

            $dataEvaluation = $this->evaluationModel->findAll();
            $lastData = end($dataEvaluation);

            $dataArray = array();
            foreach ($_POST['job_id'] as $key => $val) {
                $dataArray[] = array(
                    'evaluation_id' => $lastData['evaluationId'],
                    'job_id' => $_POST['job_id'][$key],
                    'job_score' => $_POST['value_job_type'][$key],
                    'created_at' => date('Y-m-d H:i:s')
                );
            }
            array_pop($dataArray);

            $this->evaluationJobResultsModel->insertBatch($dataArray);
            session()->setFlashdata('success_evaluation', 'Create Evaluation successfully.');
            return redirect()->to("/admin/evaluation");
        } else {
            $validation = Services::validation();
            return redirect()->to('/admin/evaluation/create')->withInput()->with('validation', $validation);
        }
    }

    public function edit($id)
    {
        $dataEvaluation = $this->evaluationModel->where(['evaluationId' => $id])->first();
        $dataEvaluationJob = $this->evaluationJobResultsModel
            ->where(['evaluation_id' => $id])
            ->join('jobs', 'jobs.jobId = evaluation_job_results.job_id')
            ->get()
            ->getResultArray();

        $dataUser = $this->userModel->findAll();
        $dataJob = $this->jobModel->findAll();

        $numItems = count($dataEvaluationJob);
        $i = 0;
        $lastIndex = 0;
        foreach ($dataEvaluationJob as $key => $value) {
            if (++$i === $numItems) {
                $lastIndex = $key;
            }
        }

        $data = [
            'page' => 'evaluation',
            'evaluation' => $dataEvaluation,
            'user' => $dataUser,
            'job' => $dataJob,
            'job_result' => $dataEvaluationJob,
            'last_index' => $lastIndex,
            'validation' => Services::validation(),
        ];

        echo view('layouts/pages/admin/evaluation/edit', $data);
    }

    public function editSave($id)
    {
        $current = $this->evaluationModel->where(['evaluationId' => $id])->first();

        $rules = [
            'user_id' => 'required',
            'disiplin' => 'required',
            'loyalitas' => 'required',
            'kerjasama' => 'required',
            'perilaku' => 'required',
        ];

        if ($this->validate($rules)) {
            $data = [
                'evaluationId' => $id,
                'user_id' => $this->request->getVar('user_id'),
                'disiplin' => $this->request->getVar('disiplin'),
                'loyalitas' => $this->request->getVar('loyalitas'),
                'kerjasama' => $this->request->getVar('kerjasama'),
                'perilaku' => $this->request->getVar('perilaku'),
                'total_sikap' => $this->request->getVar('total_sikap'),
                'total_percentage_sikap' => $this->request->getVar('total_percentage_sikap'),
                'total_working_result' => $this->request->getVar('total_working_result'),
                'total_percentage_working_result' => $this->request->getVar('total_percentage_working_result'),
                'total' => $this->request->getVar('totalNilai'),
                'predikat' => $this->request->getVar('predikat'),
                'created_at' => $current['created_at'],
                'evaluation_created' => $current['evaluation_created'],
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $this->evaluationModel->replace($data);

            $currentJobResult = $this->evaluationJobResultsModel->where(['evaluation_id' => $id])->get()->getResultArray();

            $dataArray = array();
            foreach ($currentJobResult as $key => $val) {
                $dataArray[] = array(
                    'jobResultsId' => $currentJobResult[$key]['jobResultsId'],
                    'evaluation_id' => $id,
                    'job_id' => $_POST['job_id'][$key],
                    'job_score' => $_POST['value_job_type'][$key],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );
            }
            array_pop($dataArray);
//            dd($dataArray);
            $this->evaluationJobResultsModel->updateBatch($dataArray);

            session()->setFlashdata('success_evaluation', 'Update Performance Employee successfully.');
            return redirect()->to("/admin/evaluation");
        } else {
            $validation = Services::validation();
            return redirect()->to('/admin/evaluation/edit')->withInput()->with('validation', $validation);
        }
    }

    public function detail($id)
    {
        $dataPerformance = $this->evaluationModel->where(['evaluationId' => $id])->first();
        $dataEvaluationJob = $this->evaluationJobResultsModel
            ->where(['evaluation_id' => $id])
            ->join('jobs', 'jobs.jobId = evaluation_job_results.job_id')
            ->get()
            ->getResultArray();
        $dataUser = $this->userModel->findAll();
        $dataJob = $this->jobModel->findAll();
        $data = [
            'page' => 'evaluation',
            'evaluation' => $dataPerformance,
            'user' => $dataUser,
            'job' => $dataJob,
            'job_result' => $dataEvaluationJob,
        ];

        echo view('layouts/pages/admin/evaluation/detail', $data);
    }

    public function delete($id)
    {
        $this->evaluationJobResultsModel->where(['evaluation_id' => $id])->delete();
        $this->evaluationModel->where(['evaluationId' => $id])->delete();
        session()->setFlashdata('success_evaluation', 'Delete Evaluation successfully.');
        return redirect()->to('/admin/evaluation');
    }
}
