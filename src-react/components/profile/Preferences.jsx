import React from 'react';
import Switch from '../ui/Switch';
import Container from '../ui/Container'

function Preferences() {
    return (
        <Container className={'flex-col w-full'}>
            <h4 className='font-semibold'>Préférences</h4>
            <div className='flex justify-between '>
                <p>Mode sombre</p>
                <Switch />
            </div>
            <div className='flex justify-between'>
                <p>Notifications</p>
                <Switch />
            </div>
        </Container>
    )
}

export default Preferences
