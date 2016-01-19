<?php namespace Threesquared\LaravelPaymill;

use Paymill\Request;

/**
 * Laravel wrapper for the Paymill API
 *
 * @package LaravelPaymill
 * @version 1.3
 * @author Ben Speakman <ben@3sq.re>
 */
class Paymill
{

    /**
     * The private Paymill key
     *
     * @var string
     */
    protected $private_key;

    /**
     * The Paymill model
     *
     * @var Class
     */
    public $model;

    /**
     * Constructor
     *
     * @param string $private_key
     */
    public function __construct($private_key)
    {
        $this->private_key = $private_key;
        $this->request = $this->getRequestHandler();
    }

    public function payment($id = null)
    {
        return $this->createModel('Paymill\Models\Request\Payment', $id);
    }

    public function preauthorization($id = null)
    {
        return $this->createModel('Paymill\Models\Request\Preauthorization', $id);
    }

    public function transaction($id = null)
    {
        return $this->createModel('Paymill\Models\Request\Transaction', $id);
    }

    public function refund($id = null)
    {
        return $this->createModel('Paymill\Models\Request\Refund', $id);
    }

    public function client($id = null)
    {
        return $this->createModel('Paymill\Models\Request\Client', $id);
    }

    public function offer($id = null)
    {
        return $this->createModel('Paymill\Models\Request\Offer', $id);
    }

    public function subscription($id = null)
    {
        return $this->createModel('Paymill\Models\Request\Subscription', $id);
    }

    /**
     * Create the Paymill model
     *
     * @param string $class
     * @param string $id
     * @return mixed
     */
    public function createModel($class, $id)
    {
        $this->model = new $class();

        if ($id) {
            $this->model->setId($id);
        }

        return $this;
    }

    /**
     * Create method
     *
     * @param  string   $token optional token for payment creation
     * @return Response
     */
    public function create($token = null)
    {
        if ($token) {
            $this->model->setToken($token);
        }

        return $this->request->create($this->model);
    }

    public function details()
    {
        return $this->request->getOne($this->model);
    }

    public function update()
    {
        return $this->request->update($this->model);
    }

    public function all()
    {
        return $this->request->getAll($this->model);
    }

    public function delete()
    {
        return $this->request->delete($this->model);
    }

    /**
     * Return the Paymill request class
     * @return Request
     */
    public function getRequestHandler()
    {
        return new Request($this->private_key);
    }

    /**
     * Magic method to pass methods to the Paymill model
     *
     * @param  string $name
     * @param  array  $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $return = call_user_func_array(array($this->model, $name), $arguments);

        if ($return instanceof $this->model) {
            return $this;
        }

        return $return;
    }

}
