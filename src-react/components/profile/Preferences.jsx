import React from 'react';
import Switch from '../ui/Switch';
import Container from '../ui/Container'

function Preferences() {
    return (
        <Container className={'flex-col w-[90%] m-auto md:w-full border-transparent bg-gray-100 md:bg-transparent md:border-gray-200'}>
            <h4 className='font-semibold hidden md:flex'>Préférences</h4>
            <div className='flex justify-between mb-3 mt-2'>
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
