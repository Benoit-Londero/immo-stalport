
<section id="listing-biens-projet">
    <div class="container table-children">
        <h2><strong>Biens</strong> disponibles</h2>
        <?php 
        // Récupérer les biens enfants
        $childRequest = getChildEstate($tokenClient, $parentId, getWhiseLanguageCode());
        $child = $childRequest->estates ?? array();

        if (!empty($child)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Appartements</th>
                        <th>Caractéristiques</th>
                        <th>Surfaces habitables</th>
                        <th>Prix</th>
                        <th>Disponibilités</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($child as $childEstate):
                        $childType = $childEstate->category->id ?? 'Type inconnu';
                        $childRooms = $childEstate->rooms ?? 'N/A';
                        $childArea = $childEstate->area ?? 'N/A';
                        $childPrice = $childEstate->price ?? 'N/A';
                        ?>
                        <tr>
                            <td><?php echo '<p><strong>' . $childType . '</strong></p>'; ?></td>
                            <td><?php echo '<p><strong>' . $childRooms . ' chs</strong></p>'; ?></td>
                            <td><?php echo '<p><strong>' . $childArea . '</strong></p>'; ?></td>
                            <td><?php echo '<p><strong>' . $childPrice . '</strong></p>'; ?></td>
                            <td><a href="<?php echo getUrlFromFr(18); ?>"><strong>Disponible</strong></p></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</section>