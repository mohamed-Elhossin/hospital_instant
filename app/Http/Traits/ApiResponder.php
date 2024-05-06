<?php

namespace App\Http\Traits;

trait ApiResponder
{

    protected $statusCode = 200;
    protected $success = 1;
    protected $failure = 0;

    /**
     * Getter for statusCode
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    } 
     /**
     * Getter for statusCode
     *
     * @return int
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * Setter for statusCode
     *
     * @param int $statusCode Value to set
     *
     * @return self
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    protected function respond($data, $headers = [])
    {
        return response()->json($data, $this->statusCode, $headers);
    }

    public function successStatus($message = 'Success Request')
    {
        return $this->respond([
            'status' => $this->getSuccess(),
            'message' => $message,
        ]);
    }
    public function errorStatus($message = 'Failure Request')
    {
        return $this->respond([
            'status' => 0,
            'message' => $message,
        ]);
    }



    public function respondWithItem($item, $message = 'Success Request')
    {
        return $this->respond([
            'status' => $this->getSuccess(),
            'message' => $message,
            'data' => $item,
          
        ]);
    } 
    public function respondWithItemName($item_name,$item, $message = 'Success Request')
    {
        return $this->respond([
            'status' => $this->getSuccess(),
            'message' => $message,
            $item_name => $item,
        ]);
    }
   

    public function respondWithCollection($collection,$message='Success Request')
    {
        return $this->respond([
            'status' => $this->getSuccess(),
            'message' => $message,
            'data' => $collection,
            
        ]);
    }


}
