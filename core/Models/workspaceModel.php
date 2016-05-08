<?php

/**
 * Created by PhpStorm.
 * User: Boris
 * Date: 25.01.2016
 * Time: 15:08
 */
class WorkspaceModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function GetMyEntitys($from, $param = false)
    {
        $entitys = $this->dbLink->GetEntitysInfo(paginationHelper::Limit($from), $param);
        if(count($entitys)==0 && $from > 0){
            paginationHelper::setCurrentPage($from-1);
            return $this->dbLink->GetEntitysInfo(paginationHelper::Limit($from-1), $param);
        }else{
            return $entitys;
        }
    }
    public function GetMYEntitysCount($param = false)
    {
        if(isset($param)){
            return $this->dbLink->select(array('entity' => 'e'),
                array('e' => array('Entity_Id')))
                ->innerJoin(array('entity_user'=>'eu'),array('Entity_Id' => 'EntityId'))
                ->where(array('eu.UserId'=>Auth::GetUserID(), 'e.Entity_EDRPOU' => '%'.$param.'%'),'LIKE','AND')
                ->RunQuery()->num_rows;
        }
        return $this->dbLink->select('entity_user', 'EntityId')
            ->where(array('UserId'=>Auth::GetUserID()))
            ->RunQuery()->num_rows;
    }
    public function AddOrUpdateEntity(&$arg)
    {
        $data = array();
        $validator = Validator::GetInstance();
        foreach($_POST as $key => $item){
            $data[$key] = $validator->Validate($item)->CheckForEmpty()->GetAllFields();
        }
        if(!$validator->IsError())
        {
            $nId = $this->dbLink->select('entity', 'Entity_Id')
                ->where(['Entity_EDRPOU'=>$data['Entity']['Entity_EDRPOU']])
                ->RunQuery()->fetch_assoc();
            if($nId !== false && $nId > 0){

                if($this->dbLink->UpdateEntity($nId, $data, $arg) !== false){
                    $arg['status'] = 1;
                    return true;
                }
            }else{
                $id = $this->dbLink->AddEntity($data, $arg);
                if($id !== false){
                    $arg['status'] = 1;
                    return true;
                }
            }
            $arg[] = $this->dbLink->getErrors();
            $arg['status'] = "error";
            return false;
        } else {
            $arg = $validator->getErrors();
             return false;
        }
    }
    public function GetEntityFullInfo($id)
    {
        return $this->dbLink->GetEntityInfoFull($id);
    }
}