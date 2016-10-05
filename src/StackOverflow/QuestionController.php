<?php
namespace StackOverflow;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Silex\Application;
use Silex\ControllerProviderInterface;

class QuestionController implements ControllerProviderInterface
{
    /**
     * @param Application $app
     * @return \Silex\ControllerCollection
     */
    public function connect(Application $app)
    {
        /**
         * @var \Silex\ControllerCollection $factory
         */
        $factory = $app['controllers_factory'];

        $factory->get(
            '/',
            'StackOverflow\QuestionController::getAllQuestions'
        );

        $factory->get(
            '/new',
            'StackOverflow\QuestionController::getNewQuestions'
        );

        $factory->get(
            '/week',
            'StackOverflow\QuestionController::getWeekQuestions'
        );


        $factory->get(
            '/month',
            'StackOverflow\QuestionController::getMonthQuestions'
        );

        $factory->get(
            '/{id}',
            'StackOverflow\QuestionController::get'
        );

        $factory->post(
            '/test',
            'StackOverflow\QuestionController::create'
        );

        return $factory;
    }

    /**
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAllQuestions(Application $app)
    {
        $sql = "SELECT * FROM `questions`";
        $questions = $app['db']->fetchAll($sql);

        return $app->json($questions);
    }
        /**

    /**
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getNewQuestions(Application $app)
    {
        $sql = "SELECT * FROM `questions` WHERE `created_at` > CURDATE()";
        $questions = $app['db']->fetchAll($sql);

        return $app->json($questions);
    }
        /**
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getWeekQuestions(Application $app)
    {
        $sql = "SELECT * FROM `questions` WHERE `created_at` <= ( NOW() - INTERVAL 7 DAY ) ";
        $questions = $app['db']->fetchAll($sql);
        
        return $app->json($questions);
    }

            /**
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getMonthQuestions(Application $app)
    {
        $sql = "SELECT * FROM `questions` WHERE `created_at` <= ( NOW() - INTERVAL 1 MONTH ) ";
        $questions = $app['db']->fetchAll($sql);
        
        return $app->json($questions);
    }

    /**
     * @param Application $app
     * @param $id - question Id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function get(Application $app, $id)
    {
        $questions = $this->getQuestionById($id, $app);

        if (!$questions) {
            return $app->json(array('status' => 'fail', 'errors' => 'Not found'), 404);
        }

        return $app->json($questions);
    }

   /**
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Application $app, Request $request)
    {
        $errors = $this->validate($request->request->all(), $app);
        if (count($errors) > 0) {
            $errorsArray = array();

            foreach ($errors as $error) {
                $errorsArray[$error->getPropertyPath()] = $error->getMessage();
            }

            return $app->json(array('response' => 'fail', 'errors' => $errorsArray), 400);
        }
        $insertQuestionQuery = "INSERT INTO `questions`(`title`,`text`,`tags`) VALUES(?,?,?)";

        $addQuestionResult = $app['db']->executeUpdate($insertQuestionQuery, array(
            $request->request->get("title"),
            $request->request->get("text"),
            $request->request->get("tags"),
        ));

        if (!$addQuestionResult) {
            return $app->json(array('response' => 'fail', 'errors' => 'Conflict'), 409);
        }
        $questionId = $app['db']->lastInsertId();

        return $app->json(
            array('status' => 'success', 'errors' => ''),
            201,
            array('Location' => $request->getUri() . $questionId)
        );
    }


    /**
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function options(Application $app)
    {
        return $app->json('', 200, array('Allow' => 'GET, POST, PUT, PATCH, DELETE, OPTIONS'));
    }

    /**
     * @param $id - Question id
     * @param $app
     * @return mixed
     */
    private function getQuestionById($id, $app)
    {
        $questionQuery = "SELECT * FROM `questions` WHERE `id`=?";
        $question = $app['db']->fetchArray($questionQuery, array($id));

        return $question;
    }

    /**
     * @param $question
     * @param Application $app
     * @return mixed
     */
    private function validate($question, Application $app)
    {
       
        $constraint = new Assert\Collection(array(
            'title' => new Assert\Length(array('min' => 10)),
            'text' => new Assert\Length(array('min' => 10)),
            'tags' => new Assert\Length(array('min' => 2,'max' => 10)),
            ));

        return $app['validator']->validateValue($question, $constraint);
    }
}
