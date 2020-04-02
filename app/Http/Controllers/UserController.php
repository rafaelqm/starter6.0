<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class UserController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     *
     * @param UserDataTable $userDataTable
     * @return Response
     */
    public function index(UserDataTable $userDataTable)
    {
        return $userDataTable->render('users.index');
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();

        $user = $this->userRepository->create($input);

        Flash::success(
            sprintf(
                "Usuário %s %s",
                trans('crud.saved'),
                trans('crud.successfully')
            )
        );

        return redirect(route('users.index'));
    }

    /**
     * Display the specified User.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error(__('messages.not_found', ['model' => 'Usuário']));

            return redirect(route('users.index'));
        }

        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->find($id);
        if (auth()->user()->level() != 5 && $user->id != auth()->user()->id) {
            Flash::error('Você não tem permissão de editar este usuário.');
            return back();
        }

        if (empty($user)) {
            Flash::error(__('messages.not_found', ['model' => 'Usuário']));

            return redirect(route('users.index'));
        }

        return view('users.edit')->with('user', $user);
    }

    /**
     * Update the specified User in storage.
     *
     * @param int $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserRequest $request)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error(__('messages.not_found', ['model' => 'Usuário']));

            return redirect(route('users.index'));
        }
        if (auth()->user()->level() != 5 && $user->id != auth()->user()->id) {
            Flash::error('Você não tem permissão de editar este usuário.');
            return back();
        }

        $user = $this->userRepository->update($request->all(), $id);


        Flash::success(
            sprintf(
                "Usuário %s %s",
                trans('crud.updated'),
                trans('crud.successfully')
            )
        );
        if (!auth()->user()->hasPermission('view.users')) {
            return redirect(url('/home'));
        }
        return redirect(route('users.index'));
    }

    /**
     * Remove the specified User from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error(__('messages.not_found', ['model' => 'Usuário']));

            return redirect(route('users.index'));
        }

        $user->email = 'deleted_' . $user->email;
        $user->save();
        $this->userRepository->delete($id);

        if (request()->ajax()) {
            return response()->json(
                [
                    'success' => true,
                ]
            );
        }

        Flash::success(
            sprintf(
                "Usuário %s %s",
                trans('crud.deleted'),
                trans('crud.successfully')
            )
        );

        return redirect(route('users.index'));
    }
}
