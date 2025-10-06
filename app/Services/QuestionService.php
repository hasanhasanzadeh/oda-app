<?php
namespace App\Services;


use App\Repositories\Interfaces\QuestionRepositoryInterface;

readonly class QuestionService
{
    public function __construct(private QuestionRepositoryInterface $questionRepository)
    {
    }

    public function all(array $filters=[])
    {
        return $this->questionRepository->all($filters);
    }

    public function getAll(array $filters=[])
    {
        return $this->questionRepository->getAll($filters);
    }

    public function getStatusTrueAll()
    {
        return $this->questionRepository->getStatusTrueAll();
    }

    public function find($id)
    {
        return $this->questionRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->questionRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->questionRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->questionRepository->delete($id);
    }
}
