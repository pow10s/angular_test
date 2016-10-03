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
            '/',
            'StackOverflow\QuestionController::create'
        );

/*        $factory->put(
            '/{id}',
            'StackOverflow\QuestionController::update'
        );

        $factory->patch(
            '/{id}',
            'StackOverflow\QuestionController::patch'
        );

        $factory->options(
            '/',
            'StackOverflow\QuestionController::options'
        );

        $factory->delete(
            '/{id}',
            'StackOverflow\QuestionController::delete'
        );*/

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
        $sql = "SELECT * FROM `questions` WHERE `created_at` > (NOW() - interval 7 day) AND `created_at` > (NOW() - interval 1 month)";
        $questions = $app['db']->fetchAll($sql);

        return $app->json($questions);
    }
        /**
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getWeekQuestions(Application $app)
    {
        $sql = "SELECT * FROM `questions` WHERE `created_at` < (NOW() - interval 7 day) AND `created_at` > (NOW() - interval 1 month)";
        $questions = $app['db']->fetchAll($sql);
        
        return $app->json($questions);
    }

            /**
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getMonthQuestions(Application $app)
    {
        $sql = "SELECT * FROM `questions` WHERE `created_at` < (NOW() - interval 1 month)";
        $questions = $app['db']->fetchAll($sql);
        
        return $app->json($questions);
    }

    /**
     * @param Application $app
     * @param $id - user Id
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
        $insertUsersQuery = "INSERT INTO `users`(`title`,`text`,`tags`,`user`) VALUES(?,?,?,?)";

        $addUserResult = $app['db']->executeUpdate($insertUsersQuery, array(
            $request->request->get("title"),
            $request->request->get("text"),
            $request->request->get("tags"),
            $request->request->get("user"),
        ));

        if (!$addUserResult) {
            return $app->json(array('response' => 'fail', 'errors' => 'Conflict'), 409);
        }
        $userId = $app['db']->lastInsertId();

        return $app->json(
            array('status' => 'success', 'errors' => ''),
            201,
            array('Location' => $request->getUri() . $userId)
        );
    }

    /**
     * @param Application $app
     * @param Request $request
     * @param $id
     * @param bool|false $ignoreBlank - ignoring empty field validation to realize patch request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update(Application $app, Request $request, $id, $ignoreBlank = false)
    {
        $user = $this->getUserById($id, $app);

        if (!$user) {
            return $app->json(array('status' => 'fail', 'errors' => 'Not found'), 404);
        }
        $errors = $this->validate($request->request->all(), $app, $ignoreBlank);

        if (count($errors) > 0) {
            $errorsArray = array();

            foreach ($errors as $error) {
                $errorsArray[$error->getPropertyPath()] = $error->getMessage();
            }

            return $app->json(array('response' => 'fail', 'errors' => $errorsArray), 400);
        }

        //If some fields are empty(for example in patch request), query doesn't change them
        $updateUsersQuery = "UPDATE `users` SET `name`=coalesce(?, `name`),`email`=coalesce(?, `email`),`password`=coalesce(?, `password`) WHERE id=?";

        $updateResult = $app['db']->executeUpdate($updateUsersQuery, array(
            $request->request->get("name"),
            $request->request->get("email"),
            $request->request->get("password"),
            $id
        ));

        if (!$updateResult) {
            return $app->json(array('response' => 'fail', 'errors' => 'Conflict'), 409);
        }

        return $app->json(
            array('status' => 'success', 'errors' => ''),
            204
        );
    }

    /**
     * @param Application $app
     * @param Request $request
     * @param $id - User id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function patch(Application $app, Request $request, $id)
    {
        return $this->update($app, $request, $id, true);
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
     * @param Application $app
     * @param $id - User id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function delete(Application $app, $id)
    {
        $user = $this->getUserById($id, $app);

        if (!$user) {
            return $app->json(array('status' => 'fail', 'errors' => 'Not found'), 404);
        }
        $deleteResult = $app['db']->delete('users', array('id' => $id));

        if (!$deleteResult) {
            return $app->json(array('response' => 'fail', 'errors' => 'Conflict'), 409);
        }

        return $app->json(
            array('status' => 'success', 'errors' => ''),
            204
        );
    }

    /**
     * @param $user
     * @param Application $app
     * @param bool|false $ignoreBlank - ignoring empty field validation to realize patch request
     * @return mixed
     */
    private function validate($user, Application $app, $ignoreBlank = false)
    {
        $nameValidation = array();
        $emailValidation = array();
        $passwordValidation = array();
        $constraintArray = array();

        if (isset($user['name'])) {
            $nameValidation[] = new Assert\Length(array('min' => 2));
        }

        if (isset($user['email'])) {
            $emailValidation[] = new Assert\Email();
        }

        if (isset($user['password'])) {
            $passwordValidation[] = new Assert\Length(array('min' => 6));
        }

        if (!$ignoreBlank) {
            $nameValidation[] = new Assert\NotBlank();
            $emailValidation[] = new Assert\NotBlank();
            $passwordValidation[] = new Assert\NotBlank();
        }

        if (count($nameValidation) > 0) {
            $constraintArray['name'] = $nameValidation;
        }

        if (count($emailValidation) > 0) {
            $constraintArray['email'] = $emailValidation;
        }

        if (count($passwordValidation) > 0) {
            $constraintArray['password'] = $passwordValidation;
        }
        $constraint = new Assert\Collection($constraintArray);
        $errors = $app['validator']->validateValue($user, $constraint);

        return $errors;
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
}
