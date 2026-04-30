<?php
namespace App\Services;
use App\Models\User;
use Storage;

class UserServices
{
	protected $UserModel;
    public function __construct()
    {
    	$this->UserModel = new User();
    }

    public function checkIsUserExists(array $data = [])
    {
    	return $this->UserModel->where('contact_number',$data['contact_number'])->first();
    }

    public function createUser(array $data = [])
    {
    	if(isset($data['profile_photo']))
    	{
    		$image = $data['profile_photo'];
 		   	$path = $data['profile_photo']->store('profile_images');
    	}
    	$password = rand("11111111","99999999");
    	$record = $this->UserModel;
    	$record->name = $data['name'];
    	$record->email = $data['email'];
    	$record->address = $data['address'];
    	$record->contact_number = $data['contact_number'];
    	$record->parent_contact_number = $data['parent_contact_number'];
    	$record->gender = $data['gender'];
    	$record->college_name = $data['college_name'] ?? null;
    	$record->payment_type = $data['payment_type'];
    	$record->role_id = 3;
    	$record->is_active = 0;
    	$record->password = \Hash::make($password);
    	$record->dummy_password = $password;
    	$record->amount = $data['amount'] ?? null;
    	$record->refer_code = bin2hex(random_bytes(3));
    	$record->profile_photo = $path ?? null;
    	$record->save();

    	return $record;

    }
    
    public function updateUser(array $data =[])
    {
        $record = $this->UserModel->where('id',$data['id'])->first();
        if($record)
        {
            $record->name = $data['name'];
    	    $record->email = $data['email'];
    	    $record->address = $data['address'];
    	    $record->contact_number = $data['contact_number'];
    	    if(isset($data['profile_photo']))
    	    {
    		    $image = $data['profile_photo'];
 		   	    $path = $data['profile_photo']->store('profile_images');
 		   	    $record->profile_photo = $path;
    	    }
    	    $record->gender = $data['gender'];
    	    $record->college_name = $data['college_name'] ?? null;
    	    $record->payment_type = $data['payment_type'] ?? $record->payment_type;
    	    $record->parent_contact_number = $data['parent_contact_number'];
    	    $record->amount = $data['amount'] ?? $record->amount;
    	    $record->save();
    	    return $record;
        }
        return null;
    }
    
    public function fetch($id)
    {
        $record = $this->UserModel->where('id',$id)->first();
        return $record;
    }
    
    public function updatePassword(array $data =[])
    {
        $record = $this->UserModel->where('id',$data['id'])->first();
        if($record)
        {
            $record->dummy_password = $data['password'] ?? null;
            $record->password = \Hash::make($data['password']);
            $record->save();
            return $record;
        }
        return null;
    }
    
    public function changeStatus($id)
    {
        $record = $this->UserModel->where('id',$id)->first();
        if($record && $record->is_active == 1)
        {
            $record->is_active = 0;
            $record->save();
        }
        else
        {
            $record->is_active = 1;
            $record->save();
        }
        return $record;
        
    }
    
    public function delete($id)
    {
        return $this->UserModel->where('id',$id)->delete();
    }
}
