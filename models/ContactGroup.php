<?php

namespace contacts\models;

require_once __DIR__.'/Post.php';
require_once __DIR__.'/Contact.php';

class ContactGroup
{
    /**
     * @var Contact[]
     */
    private array $contacts;
    public readonly Post $post;


    public function __construct(Contact $contact)
    {
        $this->post = $contact->post;
        $this->addContact($contact);
    }

    public function addContact(Contact $contact): void
    {
        $this->contacts[] = $contact;
    }

    public function length(): int
    {
        return count($this->contacts);
    }

    public function get(int $index): ?Contact {
        return ($index < $this->length()) ? $this->contacts[$index] : null;
    }

    public function renderForm(): string
    {
        $resp = '<div style="display: block"><h3>'.$this->post->name.'</h3>';
        foreach ($this->contacts as $item) {
            $resp .= $item->renderForm();
        }
        $resp .= "</div>";
        return $resp;
    }

    /**
     * @param Contact[] $contacts
     * @return ?ContactGroup
     */
    public static function fromArray(array $contacts): ?ContactGroup{
		if(count($contacts) == 0) return null;
        $group = new ContactGroup($contacts[0]);
        if(count($contacts) > 1){
            for ($i = 1; $i < count($contacts); $i++){
                $group->addContact($contacts[$i]);
            }
        }
        return $group;
    }

    /**
     * @param ContactGroup[] $groups
     * @return ContactGroup
     */
    public static function getLongestGroup(array $groups): ContactGroup{
        $longest = $groups[0];
        for($i = 1; $i < count($groups); $i++){
			if(empty($groups[$i])) continue;
            if($groups[$i]->length() > $longest->length()) $longest = $groups[$i];
        }
        return $longest;
    }


}