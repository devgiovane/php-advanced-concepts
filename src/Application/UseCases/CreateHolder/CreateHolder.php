<?php


namespace Study\Application\UseCases\CreateHolder;


use Study\Domain\Entities\Address;
use Study\Domain\Entities\Holder;
use Study\Domain\Repository\HolderRepository;
/**
 * Class CreateHolder
 * @package Study\Application\UseCases\CreateHolder
 */
final class CreateHolder
{
    /**
     * @var HolderRepository
     */
    private $holderRepository;

    /**
     * CreateHolder constructor.
     * @param HolderRepository $holderRepository
     */
    public function __construct(HolderRepository $holderRepository)
    {
        $this->holderRepository = $holderRepository;
    }

    /**
     * @param InputBoundary $inputBoundary
     * @return OutputBoundary
     */
    public function handle(InputBoundary $inputBoundary): OutputBoundary
    {
        $address = new Address(null, $inputBoundary->getCity(), $inputBoundary->getRoad(), $inputBoundary->getNumber());
        $holder = new Holder(null, $inputBoundary->getCpf(), $inputBoundary->getName(), $inputBoundary->getLastName(), $address);
        $idSaved = $this->holderRepository->save($holder);
        return new OutputBoundary($idSaved);
    }

}