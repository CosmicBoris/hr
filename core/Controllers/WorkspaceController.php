<?php
/**
 * Created by PhpStorm.
 * User: Boris
 * Date: 30.12.2015
 * Time: 16:56
 */
class WorkspaceController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if(Auth::isAdmin()) {
            header("Location: /super");
            exit();
        }
        else if(!Auth::IsLogged()){
            header("Location: /login");
            die();
        }
        $this->_model = new workspaceModel();
        $this->_view->SetTitle('My workspace');
    }
    public function actionIndex()
    {
        $this->_view->render();
    }
    
    public function actionEvents()
    {
        Response::ReturnJson();
        $arg = array();
        if($this->isPost()) {

        } else if(isset($_GET['id'])) {

        } else {

        }

        echo json_encode($arg);
    }
    public function actionCandidates()
    {
        $this->_view->SetTitle('Candidates');
        if($this->isAjax())
            $this->_view->partialRender();
        else {
            $this->_view->render();
        }
    }
    public function actionVacancies()
    {
        if($this->isPost()) {
            $response = array();
            $vacancy = new Vacancy($_POST);
            $vacancy->user_id = Auth::GetUserID();
            if($this->_model->AddVacancy($vacancy, $_POST['candidate_id'])) {
                $response['status'] = 1;
            } else {
                $response['error'] = $this->_model->getDBError();
            }
            Response::ReturnJson($response);
        } else {
            $this->_view->page = $_GET['page'];
            $this->_view->users = $this->_model->GetCandidates();
            $this->_view->vCount = $this->_model->vacanciesCount();
            $this->_view->vacancies = $this->_model->getVacancies($this->_view->page);

            
            $this->_view->SetTitle('Vacancies');
            if($this->isAjax())
                $this->_view->partialRender();
            else {
                $this->_view->render();
            }
        }
    }
    public function actionJournal()
    {
        /*if($csearch = $_GET['search']) {
            Response::ReturnJson();
            $resp = array('heading' => 'Результати пошуку: '.$csearch);
            $entitys = $this->_model->GetMyEntitys(Url::GetParam(), $csearch);

            foreach( $entitys as &$entity ) {
                $entity[] = htmlbuttonHelper::Form(
                    array("class"=>"btn btn-info btn-xs",
                        "id"=>$entity['Entity_EDRPOU'],
                        '<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>')
                );
                $entity[] = htmlbuttonHelper::Form(
                    array("class"=>"btn btn-warning btn-xs",
                        "id"=>$entity['Entity_EDRPOU'],
                        'ред.<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>')
                );
            }
            $ht = new htmltableHelper();
            $resp['table'] = $ht->Body($entitys)->getTbody();
            $resp['pagination'] = paginationHelper::Form(
                $this->_model->GetMYEntitysCount($csearch), "workspace/LoadMyEntitys");
            echo json_encode($resp);
        } else {
            $this->_view->heading = 'Мої підприємсва:';
            $this->_view->numRows = $this->_model->GetMYEntitysCount();
            $this->_view->myco = $this->_model->GetMyEntitys(Url::GetParam());
            $this->_view->partialRender('entityTable');
        }*/
    }
}