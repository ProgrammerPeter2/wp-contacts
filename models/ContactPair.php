<?php

namespace contacts\models;

class ContactPair
{
    public readonly Contact $original;
    public ?Contact $clone;

    /**
     * @param Contact $original
     */
    public function __construct(Contact $original)
    {
        $this->original = $original;
    }

    public function isCloneThisDataset($dataset): bool
    {
        if($dataset["id"] != $this->original->id) return false;
        $post = $this->original->post;
        $this->clone = new Contact($dataset["id"], $post, $dataset["holder"], $dataset["class"], $dataset["email"]);
        return true;
    }

	public function isTheSame(): bool{
		return $this->original->id == $this->clone->id && $this->original->class == $this->clone->class &&
		       $this->original->holder == $this->clone->holder && $this->original->email == $this->clone->email;
	}

    /**
     * @param Contact[] $contacts
     * @return ContactPair[]
     */
    public static function fromContactArray(array $contacts): array
    {
        $out = array();
        foreach ($contacts as $contact) {
            $out[] = new ContactPair($contact[0]);
        }
        return $out;
    }


}