<?php

class ContactsController extends BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /contacts
	 *
	 * @return Response
	 */
	public function index()
	{
        $sortBy = Input::get('sortBy', 'last_name');
        $direction = Input::get('direction', 'ASC');

        $contacts = Contact::orderBy($sortBy, $direction);

        $queryString = Input::get('query', '');
        if ($queryString != '') {
            $contacts->where('first_name', 'LIKE', '%'.$queryString.'%');
            $contacts->orWhere('last_name', 'LIKE', '%'.$queryString.'%');
            $contacts->orWhere('email', 'LIKE', '%'.$queryString.'%');
            $contacts->orWhere('phone', 'LIKE', '%'.$queryString.'%');
        }

        if (count($contacts) > 0) {
            $contacts = $contacts->get();
            $parsedContacts = [];
            $lastInitial = '';

            foreach ($contacts as $contact) {
                $initial = strtoupper(substr($contact->$sortBy, 0, 1));

                if ($lastInitial != $initial) {
                    $lastInitial = $initial;

                    $parsedContacts[$lastInitial]['title'] = $lastInitial;
                }

                $parsedContacts[$lastInitial]['contacts'][] = [
                    'id' => (int) $contact->id,
                    'first_name' => $contact->first_name,
                    'last_name' => $contact->last_name,
                    'email' => $contact->email,
                    'phone' => $contact->phone,
                ];
            }

            if ($direction == 'DESC') {
                $parsedContacts = rsort($parsedContacts);
            }

            return $parsedContacts;
        }

        return null;
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /contacts
	 *
	 * @return Response
	 */
	public function store()
	{
        $contact = Contact::create([
            'first_name' => Input::get('first_name'),
            'last_name' => Input::get('last_name'),
            'email' => Input::get('email'),
            'phone' => Input::get('phone'),
        ]);

        return $contact;
	}

	/**
	 * Display the specified resource.
	 * GET /contacts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return Contact::find($id);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /contacts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$contact = Contact::find($id);

        $contact->first_name = Input::get('first_name');
        $contact->last_name = Input::get('last_name');
        $contact->email = Input::get('email');
        $contact->phone = Input::get('phone');

        $contact->save();

        return $contact;
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /contacts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $contact = Contact::find($id);
        $contact->delete();

        die('DELETED');
	}

}