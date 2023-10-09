<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;



class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Route('/user/create', name: 'app_user_create', methods: ['POST'])]
    public function createUser(Request $request,  ManagerRegistry $doctrine): JsonResponse
    {
        // Decode JSON request data
        $requestData = json_decode($request->getContent(), true);

        // Create a new User object
        $user = new User();

        // Create a form instance and submit the data
        $form = $this->createForm(UserFormType::class, $user);
        $form->submit($requestData);

        // Check if the form is valid
        if ($form->isValid()) {
            // Persist the User object to the database
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();

            return $this->json([
                'message' => 'User created successfully!',
                'status' => true
            ]);
        } else {
            // If the form is not valid, return validation errors
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errors[] = $error->getMessage();
            }

            return $this->json([
                'message' => 'Validation errors',
                'errors' => $errors,
                'status' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/user/update/{id}', name: 'app_user_update', methods: ['PUT'])]
    public function updateUser(int $id, Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $em = $doctrine->getManager();
        $user = $em->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->json([
                'message' => 'User not found.',
                'status' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // Decode JSON request data
        $requestData = json_decode($request->getContent(), true);

        // Create a form instance and submit the data
        $form = $this->createForm(UserFormType::class, $user);
        $form->submit($requestData);

        // Check if the form is valid
        if ($form->isValid()) {
            // Persist the updated User object to the database
            $em->flush();

            return $this->json([
                'message' => 'User updated successfully!',
                'status' => true
            ]);
        } else {
            // If the form is not valid, return validation errors
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errors[] = $error->getMessage();
            }

            return $this->json([
                'message' => 'Validation errors',
                'errors' => $errors,
                'status' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/users', name: 'app_user_list', methods: ['GET'])]
    public function findManyUsers(Request $request, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $userRepository = $em->getRepository(User::class);

        // // Get query parameters for pagination and sorting
        $page = $request->query->getInt('page', 1); // Default page is 1
        $limit = $request->query->getInt('limit', 10); // Default limit is 10
        $sortField = $request->query->get('sortField', 'id'); // Default sort field is 'id'
        $sortOrder = $request->query->get('sortOrder', 'asc'); // Default sort order is 'asc'

        // // Create a query builder
        $queryBuilder = $userRepository->createQueryBuilder('u')
            ->orderBy("u.$sortField", $sortOrder)
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        $users = $queryBuilder->getQuery()->getResult();

        // Return the paginated users
        return $this->json([
            'users' => $users,
            'status' => true
        ]);
    }



    #[Route('/user/{id}', name: 'app_user_show', methods: ['GET'])]
    public function findUserById(int $id, ManagerRegistry $doctrine): JsonResponse
    {
        $em = $doctrine->getManager();
        $user = $em->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->json([
                'message' => 'User not found.',
                'status' => false
            ], Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            'user' => [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'surname' => $user->getSurname(),
                'dateOfBirth' => $user->getDateOfBirth(),
                'gender' => $user->getGender(),
                'status' => $user->getStatus(),
            ],
            'status' => true
        ]);
    }


    #[Route('/user/delete/{id}', name: 'app_user_delete', methods: ['DELETE'])]
    public function deleteUser(int $id, ManagerRegistry $doctrine): JsonResponse
    {
        $em = $doctrine->getManager();
        $user = $em->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->json([
                'message' => 'User not found.',
                'status' => false
            ], Response::HTTP_NOT_FOUND);
        }

        $em->remove($user);
        $em->flush();

        return $this->json([
            'message' => 'User deleted successfully!',
            'status' => true
        ]);
    }
}
