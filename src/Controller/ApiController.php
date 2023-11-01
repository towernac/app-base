<?php
/**
 * @copyright 2022 Anthon Pang
 */
namespace App\Controller;

use App\Controller\AbstractController;
use App\Service\XmlService;

/**
 * API controller
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */
class ApiController extends AbstractController
{
    /**
     * @var string
     */
    protected $method;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var \App\Service\XmlService
     */
    protected $xmlService;

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        parent::__construct();

        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->data = $_POST;

        if ( ! isset($_SERVER['CONTENT_TYPE'])) {
            return;
        }

        if (preg_match('/~^application/json(;|$)~', $_SERVER['CONTENT_TYPE'])) {
            $this->data = json_decode(file_get_contents('php://input'), true);
        /*
        } elseif (preg_match('~^text/xml(;|$)~', $_SERVER['CONTENT_TYPE']) ||
            preg_match('~^application/xml(;|$)~', $_SERVER['CONTENT_TYPE'])
        ) {
            $this->data = $this->xmlService->deserialize(file_get_contents('php://input'));
        */
        }
    }

    /**
     * Inject services
     *
     * @param \App\Service\XmlService $xmlService
     */
    public function setServices(XmlService $xmlService)
    {
        $this->xmlService = $xmlService;
    }

    /**
     * OPTIONS
     */
    public function optionsAction()
    {
        $this->render(__METHOD__, ['method' => $this->method]);
    }

    /**
     * HEAD
     */
    public function headAction()
    {
        $this->render(__METHOD__, ['method' => $this->method]);
    }

    /**
     * POST
     */
    public function postAction()
    {
        $this->render(__METHOD__, ['method' => $this->method, 'params' => $this->params, 'body' => $this->data]);
    }

    /**
     * GET
     */
    public function getAction()
    {
        $this->render(__METHOD__, [rand(1,9), rand(1,9), rand(1000,9999), rand(1,5), rand(555,297834)]);

    }

    /**
     * PUT
     */
    public function putAction()
    {
        $this->render(__METHOD__, ['method' => $this->method, 'params' => $this->params, 'body' => $this->data]);
    }

    /**
     * DELETE
     */
    public function deleteAction()
    {
        $this->render(__METHOD__, ['method' => $this->method, 'params' => $this->params]);
    }

    /**
     * Render view
     *
     * @param string     $sourceMethod
     * @param array|null $params
     */
    protected function render($sourceMethod, $params = null)
    {
        /*
        if (isset($_SERVER['HTTP_ACCEPT']) && preg_match('~^text/xml([,;]|$)~', $_SERVER['HTTP_ACCEPT'])) {
            header('Content-Type: text/xml');

            echo $this->xmlService->serialize($params);

            return;
        }
        */

        header('Content-Type: application/json');

        if ($params !== null) {
            echo json_encode($params);
        }
    }
}
